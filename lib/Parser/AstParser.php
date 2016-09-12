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

        var_dump($ast);
        print ast_dump($ast);

        $context = [
            'variables' => [],
            'in_if_statement' => false,
            'in_condition' => false
        ];
        return $this->parse($ast, $context, 1);
    }

    /**
     * Parse AST for php extension
     *
     * @param  array|ast\Node $ast        Ast to parse
     * @param  array          &$context   Variables declared in the current scope
     * @param  int            $indent     Indent size
     * @param  int            $loopIndex  Loop index in case of a loop over children
     *
     * @return string
     */
    private function parse($ast, array &$context, int $indent, int $loopIndex = 0)
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
            foreach ($ast as $key => $child) {
                $result .= $this->parse($child, $context, $indent, $key);
            }

            return $result;
        }

        // string/int/bool ... (in condition)
        if (!$ast instanceof \ast\Node) {
            // Quote strings
            if (is_string($ast)) {
                return '"' . str_replace("\"", "\\\"", $ast) . '"';
            }

            return $ast;
        }

        // Node type
        switch ($ast->kind) {
            case \ast\AST_STMT_LIST:
                $result .= $this->parse($ast->children, $context, $indent + 1);
                break;

            case \ast\AST_RETURN:
                $result .= Utils::indent($indent) . 'return ';
                $result .= $this->parse($ast->children, $context, $indent);
                $result .= ';' . PHP_EOL;
                break;

            case \ast\AST_IF:
                $context['in_if_statement'] = true;
                $result .= $this->parse($ast->children, $context, $indent);
                $context['in_if_statement'] = false;
                break;

            // if / elseif / else : "else if" is forbidden
            case \ast\AST_IF_ELEM:
                // Set to false in order to parse deep if statements
                $context['in_if_statement'] = false;

                if (is_null($ast->children['cond'])) {
                    $result .= Utils::indent($indent) . 'else {' . PHP_EOL;
                } else {
                    $result .= $loopIndex == 0
                        ? Utils::indent($indent) . 'if'
                        : Utils::indent($indent) . 'elseif'
                    ;

                    $context['in_condition'] = true;
                    $result .= $this->parse($ast->children['cond'], $context, $indent);
                    $context['in_condition'] = false;

                    $result .= '{' . PHP_EOL;
                }

                $result .= $this->parse($ast->children['stmts'], $context, $indent);
                $result .= Utils::indent($indent) . '}' . PHP_EOL;
                $context['in_if_statement'] = true;
                break;

            // Condition
            case \ast\AST_BINARY_OP:
                $result .= ' (' . $this->parse($ast->children['left'], $context, $indent);
                $result .= $this->getStringForFlag($ast->flags);
                $result .= $this->parse($ast->children['right'], $context, $indent) . ') ';
                break;

            // Variable printing
            case \ast\AST_VAR:
                $result .= $ast->children['name'];
                break;
        }

        return $result;
    }

    /**
     * Returns string associated to the given flag
     *
     * @param  int    $flag
     *
     * @return string
     */
    private function getStringForFlag(int $flag)
    {
        switch ($flag) {
            case \ast\flags\BINARY_BITWISE_OR:
                return '';
                break;
            case \ast\flags\BINARY_BITWISE_AND:
                return '';
                break;
            case \ast\flags\BINARY_BITWISE_XOR:
                return '';
                break;
            case \ast\flags\BINARY_CONCAT:
                return '.';
                break;
            case \ast\flags\BINARY_ADD:
                return '+';
                break;
            case \ast\flags\BINARY_SUB:
                return '-';
                break;
            case \ast\flags\BINARY_MUL:
                return '*';
                break;
            case \ast\flags\BINARY_DIV:
                return '/';
                break;
            case \ast\flags\BINARY_MOD:
                return '%';
                break;
            case \ast\flags\BINARY_POW:
                return '^';
                break;
            case \ast\flags\BINARY_SHIFT_LEFT:
                return '<<';
                break;
            case \ast\flags\BINARY_SHIFT_RIGHT:
                return '>>';
                break;
            case \ast\flags\BINARY_BOOL_AND:
                return '&&';
                break;
            case \ast\flags\BINARY_BOOL_OR:
                return '||';
                break;
            case \ast\flags\BINARY_BOOL_XOR:
                return 'or';
                break;
            case \ast\flags\BINARY_IS_IDENTICAL:
                return '==';
                break;
            case \ast\flags\BINARY_IS_NOT_IDENTICAL:
                return '!=';
                break;
            case \ast\flags\BINARY_IS_EQUAL:
                return '==';
                break;
            case \ast\flags\BINARY_IS_NOT_EQUAL:
                return '!=';
                break;
            case \ast\flags\BINARY_IS_SMALLER:
                return '<';
                break;
            case \ast\flags\BINARY_IS_SMALLER_OR_EQUAL:
                return '<=';
                break;
            case \ast\flags\BINARY_IS_GREATER:
                return '>';
                break;
            case \ast\flags\BINARY_IS_GREATER_OR_EQUAL:
                return '>=';
                break;
            case \ast\flags\BINARY_SPACESHIP:
                return '';
                break;
            case \ast\flags\BINARY_COALESCE:
                return '';
                break;
        }

        return '';
    }
}
