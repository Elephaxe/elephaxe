<?php

namespace Elephaxe\Haxe;

use PHPUnit\Framework\TestCase;
use Elephaxe\Haxe\HaxeConstant;

class HaxeConstantTest extends TestCase
{
    /**
     * private/public var test : type = "5";
     */
    public function testConstantWithValue()
    {
        $attribute = new HaxeConstant();
        $attribute
            ->setName('test')
            ->setValue('"5"')
        ;

        $this->assertEquals('public static var test = "5";', $attribute->transpile());
    }
}

?>
