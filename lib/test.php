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
        if ($z > 5) {
            return 3;
        } elseif ($z <= 2 && ($z >= 0 && $x == "elephaxe")) {
            return 1;
        } else {
            return 2;
        }

        return 2;
    }
}
