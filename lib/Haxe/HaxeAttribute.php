<?php

namespace Elephaxe\Haxe;

use Elephaxe\TranspilerInterface;

class HaxeAttribute implements TranspilerInterface
{
    const ATTRIBUTE_VISIBILITY_PUBLIC = 'public';
    const ATTRIBUTE_VISIBILITY_PRIVATE = 'private';

    const UNKNOWN_TYPE = 'Dynamic';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type = self::UNKNOWN_TYPE;

    /**
     * @var bool
     */
    private $isStatic;

    /**
     * @var string
     */
    private $visibility = self::ATTRIBUTE_VISIBILITY_PUBLIC;

    /**
     * @var string
     */
    private $value;

    /**
     * {@inheritDoc}
     */
    public function transpile()
    {
        $result = $this->visibility;

        if ($this->isStatic) {
            $result .= ' static';
        }

        $result .= sprintf(' var %s', $this->name);

        if ($this->type) {
            $result .= sprintf(' : %s', $this->type);
        }

        if ($this->value) {
            $result .= sprintf(' = %s', $this->value);
        }

        $result .= ';';

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
     * Get the value of Is Static
     *
     * @return bool
     */
    public function getIsStatic()
    {
        return $this->isStatic;
    }

    /**
     * Set the value of Is Static
     *
     * @param bool $isStatic
     *
     * @return self
     */
    public function setIsStatic($isStatic)
    {
        $this->isStatic = $isStatic;

        return $this;
    }

    /**
     * Get the value of Visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the value of Visibility
     *
     * @param string $visibility
     *
     * @return self
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

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

}
