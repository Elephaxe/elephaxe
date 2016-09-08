<?php

namespace Elephaxe\Haxe;

use Elephaxe\Haxe\HaxeAttribute;
use Elephaxe\Haxe\HaxeMethod;
use Elephaxe\Haxe\HaxeConstant;
use Elephaxe\TranspilerInterface;

class HaxeClass implements TranspilerInterface
{
    /**
     * @var string
     */
    private $package;

    /**
     * @var array
     */
    private $imports;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $implements;

    /**
     * @var string
     */
    private $extends;

    /**
     * @var HaxeAttribute[]
     */
    private $attributes;

    /**
     * @var HaxeMethod[]
     */
    private $methods;

    /**
     * @var HaxeConstant[]
     */
    private $constants;

    public function __construct()
    {
        $this->attributes = [];
        $this->methods = [];
        $this->constants = [];
        $this->imports = [];
        $this->implements = [];
    }

    /**
     * {@inheritDoc}
     */
    public function transpile()
    {
        if ($this->package) {
            $result .= sprintf('package %s;' . PHP_EOL, $this->package);
        }

        foreach ($this->imports as $import) {
            $result .= sprintf('import %s;' . PHP_EOL, $import);
        }

        // @todo extends/implements
        $result .= sprintf('class %s' . PHP_EOL, $this->name);
        $result .= '{' . PHP_EOL;

        foreach ($this->attributes as $attribute) {
            $result .= $attribute->transpile() . PHP_EOL;
        }

        foreach ($this->methods as $method) {
            $result .= $method->transpile() . PHP_EOL;
        }

        $result .= '}';

        return $result;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Implements
     *
     * @return string[]
     */
    public function getImplements()
    {
        return $this->implements;
    }

    /**
     * Set the value of Implements
     *
     * @param string[] $implements
     *
     * @return self
     */
    public function setImplements(array $implements)
    {
        $this->implements = $implements;

        return $this;
    }

    /**
     * Get the value of Extends
     *
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * Set the value of Extends
     *
     * @param string $extends
     *
     * @return self
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * Get the value of Attributes
     *
     * @return HaxeAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the value of Attributes
     *
     * @param HaxeAttribute[] $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Adds an attribute into the class
     *
     * @param HaxeAttribute $attribute
     *
     * @return self
     */
    public function addAttribute(HaxeAttribute $attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * Get the value of Methods
     *
     * @return HaxeMethod[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Set the value of Methods
     *
     * @param HaxeMethod[] $methods
     *
     * @return self
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * Adds a new method to the class
     *
     * @param HaxeMethod $method
     *
     * @return self
     */
    public function addMethod(HaxeMethod $method)
    {
        $this->methods[] = $method;

        return $this;
    }

    /**
     * Get the value of Constants
     *
     * @return HaxeConstant[]
     */
    public function getConstants()
    {
        return $this->constants;
    }

    /**
     * Set the value of Constants
     *
     * @param HaxeConstant[] $constants
     *
     * @return self
     */
    public function setConstants(array $constants)
    {
        $this->constants = $constants;

        return $this;
    }

    /**
     * Adds a new constant to the class
     *
     * @param HaxeConstant $constant
     *
     * @return self
     */
    public function addConstant(HaxeConstant $constant)
    {
        $this->constants[] = $constant;

        return $this;
    }

    /**
     * Get the value of Package
     *
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set the value of Package
     *
     * @param string $package
     *
     * @return self
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get the value of Imports
     *
     * @return array
     */
    public function getImports()
    {
        return $this->imports;
    }

    /**
     * Set the value of Imports
     *
     * @param array $imports
     *
     * @return self
     */
    public function setImports(array $imports)
    {
        $this->imports = $imports;

        return $this;
    }
}
