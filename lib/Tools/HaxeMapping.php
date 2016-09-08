<?php

namespace Elephaxe\Tools;

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
            'void'   => 'Void'
        ];

        return isset($defaultMapping[$type]) ? $defaultMapping[$type] : $type;
    }
}
