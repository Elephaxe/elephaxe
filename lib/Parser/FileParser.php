<?php

namespace Elephaxe\Parser;

use Elephaxe\Parser\Context;
use Elephaxe\Haxe\HaxeClass;
use Elephaxe\Haxe\HaxeAttribute;
use Elephaxe\Tools\DocParser;

/**
 * Top parser
 */
class FileParser
{
    const USE_PATTERN = '/(?:use)(?:[^\w\\\\])([\w\\\\]+)(?![\w\\\\])(?:(?:[ ]+as[ ]+)(\w+))?(?:;)/';
    const NAMESPACE_PATTERN = '/(?:namespace)(?:[^\w\\\\])([\w\\\\]+)(?![\w\\\\])(?:;)/';
    const DEFINITION_PATTERN = '/(?:abstract class|class|trait|interface)\s+(\w+)/';

    /**
     * Each line of the file
     * @var array
     */
    private $data;

    /**
     * Context represents the state of the parsing
     * @var Context
     */
    private $context;

    /**
     * Parse the given file
     * @param  string $file Full path to the file
     */
    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(sprintf('File %s not found'));
        }

        // Get all lines of the file
        $this->data = file($file);
    }

    /**
     * Process the parsing
     *
     * @return string Haxe code
     */
    public function process()
    {
        $this->context = new Context();
        $this->buildClassMeta();
    }

    /**
     * Builds metadata of the class in the file
     */
    private function buildClassMeta()
    {
        // Search meta informations before going to reflection and then, ast parsing
        foreach ($this->data as $line) {
            $line = trim($line);

            // Namespace search
            if (preg_match(self::NAMESPACE_PATTERN, $line, $matches) === 1) {
                $context->setCurrentNamespace(trim($matches[1]));
                continue;
            }

            // Class name
            if (preg_match(self::DEFINITION_PATTERN, $line, $matches) === 1) {
                $context->setClassName(trim($matches[1]));
                break; // Stop after class found, let the reflection do the next job
            }

            // Uses
            if (preg_match(self::USE_PATTERN, $line, $matches) === 1) {
                $context->addUse($matches[1]);
                continue;
            }
        }
    }

    /**
     * Builds class attributes and methods
     */
    private function buildClassDefinition()
    {
        $reflection = new \ReflectionClass($this->context->getFullClassName());
        $haxeClass = new HaxeClass();
        $haxeClass->setPackage(implode('.', explode('\\', $this->context->getCurrentNamespace())));

        // Retrieves information about properties/attributes.
        foreach ($reflection->getProperties() as $attribute) {
            // Inherited method not write there.
            if ($attribute->getDeclaringClass() != $this->context->getClassName()) {
                continue;
            }

            $haxeAttribute = new HaxeAttribute();
            $haxeAttribute
                ->setName($attribute->getName())
                ->setIsStatic($attribute->isStatic())
                ->setVisibility($attribute->isPrivate()
                    ? HaxeAttribute::ATTRIBUTE_VISIBILITY_PRIVATE
                    : HaxeAttribute::ATTRIBUTE_VISIBILITY_PUBLIC
                )
                ->setType(DocParser::getVarType($attribute->getDocComment()) ?: Context::DEFAULT_TYPE)
            ;

            $haxeClass->addAttribute($haxeAttribute);
        }
    }
}
