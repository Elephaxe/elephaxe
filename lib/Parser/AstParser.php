<?php

namespace Elephaxe\Parser;

use Elephaxe\Tools\Utils;

/**
 * Parse AST from php extension
 */
class AstParser
{
    const API_VERSION = 30;

    /**
     * @var string
     */
    private $code;

    /**
     * @param array $code
     */
    public function __construct(array $code)
    {
        $this->code = '<?php ';
        $this->code .= ltrim(rtrim(trim(implode("\n", $code)), '}'), '{');
        $this->code .= ' ?>';
    }

    /**
     * Parse PHP code and returns haxe code
     *
     * @return string
     */
    public function process()
    {
        $ast = \ast\parse_code($this->code, $version=self::API_VERSION);

        // var_dump($ast);
        // print ast_dump($ast);

        $variables = [];
        return $this->parse($ast, $variables, 1);
    }

    /**
     * Parse AST for php extension
     *
     * @param  array|ast\Node $ast        Ast to parse
     * @param  array          &$variables Variables declared in the current scope
     * @param  int            $indent     Indent size
     *
     * @return string
     */
    private function parse($ast, &$variables, $indent)
    {
        $result = '';

        // No children
        if (is_null($ast)) {
            return $result;
        }

        // Expression
        if (is_array($ast) && isset($ast['expr'])) {
            return $ast['expr'];
        }

        // Array of nodes
        if (is_array($ast)) {
            foreach ($ast as $child) {
                $result .= $this->parse($child, $variables, $indent);
            }

            return $result;
        }

        // Node type
        switch ($ast->kind) {
            case \ast\AST_STMT_LIST:
                $result .= $this->parse($ast->children, $variables, $indent + 1);
                break;

            case \ast\AST_RETURN:
                $result .= Utils::indent($indent);
                $result .= 'return ';
                $result .= $this->parse($ast->children, $variables, $indent);
                $result .= ';';
                break;
        }

        return $result;
    }
}
