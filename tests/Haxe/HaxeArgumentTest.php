<?php

namespace Elephaxe\Haxe;

use PHPUnit\Framework\TestCase;
use Elephaxe\Haxe\HaxeArgument;

class HaxeArgumentTest extends TestCase
{
    /**
     * test = "5"
     */
    public function testArgumentWithValue()
    {
        $argument = new HaxeArgument();
        $argument
            ->setName('test')
            ->setValue('"5"')
        ;

        $this->assertEquals('test = "5"', $argument->transpile());
    }

    /**
     * ?test
     */
    public function testOptionalArgument()
    {
        $argument = new HaxeArgument();
        $argument
            ->setName('test')
            ->setOptional(true)
        ;

        $this->assertEquals('?test', $argument->transpile());
    }

    /**
     * test : String
     */
    public function testTypeArgument()
    {
        $argument = new HaxeArgument();
        $argument
            ->setName('test')
            ->setType('String')
        ;

        $this->assertEquals('test : String', $argument->transpile());
    }

    /**
     * ?test : String = "5"
     */
    public function testEverythingArgument()
    {
        $argument = new HaxeArgument();
        $argument
            ->setName('test')
            ->setOptional(true)
            ->setType('String')
            ->setValue('"5"');
        ;

        $this->assertEquals('?test : String = "5"', $argument->transpile());
    }
}

?>
