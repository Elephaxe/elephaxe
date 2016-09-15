<?php

namespace Elephaxe\Tools;

use Elephaxe\Parser\Context;

class HaxeMapping
{
    /**
     * Returns the corresponding haxe type for the php type given
     *
     * @param  string $type PHP type
     *
     * @return string
     */
    public static function getHaxeType($type)
    {
        $type = trim($type);

        $defaultMapping = [
            'string' => 'String',
            'int'    => 'Int',
            'bool'   => 'Bool',
            'float'  => 'Float',
            'array'  => 'Array<Dynamic>',
            'void'   => 'Void',
            'mixed'  => 'Dynamic'
        ];

        return isset($defaultMapping[$type]) ? $defaultMapping[$type] : $type;
    }

    /**
     * Try to find the type of the given $value
     *
     * @param  mixed $value Value to guess
     *
     * @return string
     */
    public static function guessValueType($value)
    {
        if (is_int($value)) {
            return self::getHaxeType('int');
        }

        if (is_bool($value)) {
            return self::getHaxeType('bool');
        }

        if (is_float($value)) {
            return self::getHaxeType('float');
        }

        if (is_string($value)) {
            return self::getHaxeType('string');
        }

        return Context::DEFAULT_TYPE;
    }
}
