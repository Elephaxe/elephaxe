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

    /**
     * {@inheritDoc}
     */
    public function transpile()
    {
        return '';
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
}
