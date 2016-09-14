<?php

class Test
{
    public static function main()
    {
        echo "Hello World";

        self::testExplode();
    }

    public static function testExplode()
    {
        return explode(',', "Test,explode");
    }
}
