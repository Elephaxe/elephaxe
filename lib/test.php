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
        explode(',', "test");

        if (1 == 1) {
            explode(',', "test2");
        }

        return explode(',', "test3");
    }
}
