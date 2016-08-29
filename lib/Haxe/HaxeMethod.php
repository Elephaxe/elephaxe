<?php

namespace Elephaxe\Haxe;

use Elephaxe\TranspilerInterface;
use Elephaxe\Haxe\HaxeArgument;

class HaxeMethod implements TranspilerInterface
{
    const ATTRIBUTE_VISIBILITY_PUBLIC = 'public';
    const ATTRIBUTE_VISIBILITY_PRIVATE = 'private';

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isStatic;

    /**
     * @var string
     */
    private $visibility = self::ATTRIBUTE_VISIBILITY_PUBLIC;

    /**
     * @var HaxeArgument[]
     */
    private $arguments = array();

    /**
     * {@inheritDoc}
     */
    public function transpile()
    {
        $result = $this->visibility;

        if ($this->isStatic) {
            $result .= ' static';
        }

        $result .= sprintf(' function %s(', $this->name);

        $arguments = [];
        foreach ($this->arguments as $arg) {
            $arguments[] = $arg->transpile();
        }

        $result .= join(', ', $arguments);
        $result .= ')';

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
     * Get the value of Arguments
     *
     * @return string
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set the value of Arguments
     *
     * @param string $arguments
     *
     * @return self
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

}
