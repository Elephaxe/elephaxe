<?php

namespace Elephaxe\Haxe;

use Elephaxe\TranspilerInterface;

class HaxeArgument implements TranspilerInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $optional;

    /**
     * @var string
     */
    private $value;

    /**
     * {@inheritDoc}
     */
    public function transpile()
    {
        $result = sprintf('%s%s', $this->optional ? '?' : '', $this->name);

        if ($this->type) {
            $result .= sprintf(' : %s', $this->type);
        }

        if ($this->value) {
            $result .= sprintf(' = %s', $this->value);
        }

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
     * Get the value of Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of Optional
     *
     * @return bool
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * Set the value of Optional
     *
     * @param bool $optional
     *
     * @return self
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;

        return $this;
    }

    /**
     * Get the value of Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of Value
     *
     * @param string $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

}
