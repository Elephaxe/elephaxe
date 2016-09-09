<?php

namespace Test\Haxe;

class MyClass
{
    /**
     * @var string
     */
    private $test;

    private $myvar;

    public function __construct() {

    }

    public function test(string $x, $z = 5) : int {
        return 2;
    }
}
