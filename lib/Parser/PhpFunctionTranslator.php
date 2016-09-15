<?php

namespace Elephaxe\Parser;

/**
 * Utils to translate a php function (e.g : explode) into haxe code
 */
class PhpFunctionTranslator
{
    /**
     * Translate the function into haxe
     *
     * @param  string $name function name
     * @param  array  $args function args
     *
     * @return string Haxe code
     */
    public static function translate(string $name, array $args) : string
    {
        switch ($name) {
            case 'explode':
                self::checkArgsNumber($name, $args, 2);

                return sprintf('%s.split(%s)', array_pop($args), implode(', ', $args));
                break;
        }

        throw new ParserException([sprintf('Function %s not supported', $name)]);
    }

    /**
     * Check if $args contains too much informations or not ('cause haxe functions could have less parameters)
     *
     * @param  string $name Function name
     * @param  array  $args Function args
     * @param  int    $max  Max args authorized
     */
    private static function checkArgsNumber(string $name, array &$args, int $max)
    {
        if (count($args) > $max) {
            throw new ParserException([sprintf('Function %s can\'t have more than %d arguments', $name, $max)]);
        }
    }
}
