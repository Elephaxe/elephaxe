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
        if ($z == 5) {
            $u = 5;
            $this->test = "ok";
        }
        if ($z == 5) {
            $u = 2;
        }

        return $z;
    }
}
