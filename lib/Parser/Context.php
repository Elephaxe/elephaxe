<?php

namespace Elephaxe\Parser;

/**
 * Represents all data of the current file parsed
 */
class Context
{
    const DEFAULT_TYPE = 'Dynamic';
    const NO_TYPE = 'Void';

    /**
     * @var string
     */
    private $currentNamespace;

    /**
     * @var array
     */
    private $uses;

    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var array
     */
    private $methods;

    public function __construct()
    {
        $this->uses = [];
        $this->attributes = [];
        $this->methods = [];
    }

    /**
     * Returns the full name of the class (with namespace)
     *
     * @return string
     */
    public function getFullClassName()
    {
        return $this->currentNamespace
            ? $this->currentNamespace . '\\' . $this->className
            : $this->className
        ;
    }

    /**
     * Get the value of Current Namespace
     *
     * @return string
     */
    public function getCurrentNamespace()
    {
        return $this->currentNamespace;
    }

    /**
     * Set the value of Current Namespace
     *
     * @param string $currentNamespace
     *
     * @return self
     */
    public function setCurrentNamespace($currentNamespace)
    {
        $this->currentNamespace = $currentNamespace;

        return $this;
    }

    /**
     * Get the value of Uses
     *
     * @return array
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Set the value of Uses
     *
     * @param array $uses
     *
     * @return self
     */
    public function setUses(array $uses)
    {
        $this->uses = $uses;

        return $this;
    }

    /**
     * Get the value of Class Name
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set the value of Class Name
     *
     * @param string $className
     *
     * @return self
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get the value of Attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the value of Attributes
     *
     * @param array $attributes
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
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Set the value of Methods
     *
     * @param array $methods
     *
     * @return self
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * Adds a use to the use list
     *
     * @param string $use
     */
    public function addUse($use)
    {
        $this->uses[] = $use;
    }
}
