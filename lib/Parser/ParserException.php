<?php

namespace Elephaxe\Parser;

/**
 * Error thrown while parsing a piece of code
 */
class ParserException extends \Exception
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the value of Errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of Errors
     *
     * @param array $errors
     *
     * @return self
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

}
