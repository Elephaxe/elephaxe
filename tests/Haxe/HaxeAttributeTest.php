<?php

namespace Elephaxe\Haxe;

use PHPUnit\Framework\TestCase;
use Elephaxe\Haxe\HaxeAttribute;

class HaxeAttributeTest extends TestCase
{
    /**
     * private/public var test : type;
     */
    public function testAttributeSimple()
    {
        $attribute = new HaxeAttribute();
        $attribute
            ->setName('test')
            ->setVisibility('public')
        ;

        $this->assertEquals('public var test : Dynamic;', $attribute->transpile());
    }

    /**
     * private/public var test : type = "5";
     */
    public function testAttributeWithValue()
    {
        $attribute = new HaxeAttribute();
        $attribute
            ->setName('test')
            ->setVisibility('public')
            ->setType('String')
            ->setValue('"5"')
        ;

        $this->assertEquals('public var test : String = "5";', $attribute->transpile());
    }

    /**
     * private/public static var test : type;
     */
    public function testAttributeStatic()
    {
        $attribute = new HaxeAttribute();
        $attribute
            ->setName('test')
            ->setVisibility('private')
            ->setIsStatic(true)
        ;

        $this->assertEquals('private static var test : Dynamic;', $attribute->transpile());
    }
}

?>
