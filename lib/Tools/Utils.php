<?php

namespace Elephaxe\Tools;

/**
 * Some functions that helps a lot (or at least, a little)
 */
class Utils
{
    const INDENT_PADDING = 4;

    /**
     * Indent $size * self::INDENT_PADDING
     *
     * @param  int $size
     *
     * @return string
     */
    public static function indent($size)
    {
        return str_repeat(' ', $size * self::INDENT_PADDING);
    }
}
