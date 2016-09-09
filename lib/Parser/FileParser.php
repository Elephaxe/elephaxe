<?php

namespace Elephaxe\Parser;

use Elephaxe\Parser\Context;
use Elephaxe\Parser\AstParser;
use Elephaxe\Haxe\HaxeClass;
use Elephaxe\Haxe\HaxeMethod;
use Elephaxe\Haxe\HaxeArgument;
use Elephaxe\Haxe\HaxeAttribute;
use Elephaxe\Tools\DocParser;
use Elephaxe\Tools\HaxeMapping;

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
        return $this->buildClassDefinition();
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
                $this->context->setCurrentNamespace(trim($matches[1]));
                continue;
            }

            // Class name
            if (preg_match(self::DEFINITION_PATTERN, $line, $matches) === 1) {
                $this->context->setClassName(trim($matches[1]));
                break; // Stop after class found, let the reflection do the next job
            }

            // Uses
            if (preg_match(self::USE_PATTERN, $line, $matches) === 1) {
                $this->context->addUse($matches[1]);
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
        $haxeClass
            ->setName($this->context->getClassName())
            ->setPackage(implode('.', explode('\\', $this->context->getCurrentNamespace())))
        ;

        $this->parseProperties($reflection, $haxeClass);
        $this->parseMethods($reflection, $haxeClass);

        return $haxeClass->transpile();
    }

    /**
     * Parse reflection class's properties
     *
     * @param  ReflectionClass $reflection
     * @param  HaxeClass       $haxeClass
     */
    private function parseProperties(\ReflectionClass $reflection, HaxeClass $haxeClass)
    {
        // Retrieves information about properties/attributes.
        foreach ($reflection->getProperties() as $attribute) {
            // Inherited method not write there.
            if ($attribute->getDeclaringClass()->getName() != $this->context->getFullClassName()) {
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
                ->setType(DocParser::getVarType($attribute->getDocComment())
                    ? HaxeMapping::getHaxeType(DocParser::getVarType($attribute->getDocComment()))
                    : Context::DEFAULT_TYPE
                )
            ;

            $haxeClass->addAttribute($haxeAttribute);
        }
    }

    /**
     * Parse methods from the ReflectionClass
     *
     * @param  ReflectionClass $reflection
     * @param  HaxeClass       $haxeClass
     */
    private function parseMethods(\ReflectionClass $reflection, HaxeClass $haxeClass)
    {
        // Retrieves information about methods
        foreach ($reflection->getMethods() as $method) {
            // Inherited method not write there.
            if ($method->getDeclaringClass()->getName() != $this->context->getFullClassName()) {
                continue;
            }

            $code = $this->data;
            $astParser = new AstParser(array_splice(
                $code,
                $method->getStartLine(),
                $method->getEndLine() - $method->getStartLine()
            ));

            $haxeMethod = new HaxeMethod();
            $haxeMethod
                ->setName($method->getName() != '__construct' ? $method->getName() : 'new') // new in haxe
                ->setIsStatic($method->isStatic())
                ->setVisibility($method->isPrivate()
                    ? HaxeMethod::METHOD_VISIBILITY_PRIVATE
                    : HaxeMethod::METHOD_VISIBILITY_PUBLIC
                )
                ->setReturnType($method->hasReturnType()
                    ? HaxeMapping::getHaxeType($method->getReturnType())
                    : Context::DEFAULT_TYPE
                )
                ->setBody($astParser->process());
            ;

            $this->parseArguments($method, $haxeMethod);
            $haxeClass->addMethod($haxeMethod);
        }
    }

    /**
     * Parse function's arguments
     *
     * @param  ReflectionFunctionAbstract $reflection
     * @param  HaxeMethod                 $haxeMethod
     */
    private function parseArguments(\ReflectionFunctionAbstract $reflection, HaxeMethod $haxeMethod)
    {
        $args = $reflection->getParameters();

        $optionals = array();
        $parameters = array();

        foreach ($args as $argument) {
            $haxeArgument = new HaxeArgument();
            $defaultType = $argument->isOptional()
                ? HaxeMapping::guessValueType($argument->getDefaultValue())
                : Context::DEFAULT_TYPE
            ;

            $haxeArgument
                ->setName($argument->getName())
                ->setOptional($argument->isOptional())
                ->setType($argument->hasType() ? HaxeMapping::getHaxeType($argument->getType()) : $defaultType)
                ->setValue($argument->isOptional() ? $argument->getDefaultValue() : null)
            ;

            $haxeMethod->addArgument($haxeArgument);
        }
    }
}
