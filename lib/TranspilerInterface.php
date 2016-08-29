<?php

namespace Elephaxe;

/**
 * Interface that give methods to write haxe code
 */
interface TranspilerInterface
{
    /**
     * Returns a string of haxe code
     *
     * @return string
     */
    public function transpile();
}
