<?php

require '../php-ast/util.php';
require __DIR__ .'/TranspilerInterface.php';
require __DIR__ .'/Haxe/HaxeArgument.php';
require __DIR__ .'/Haxe/HaxeMethod.php';

echo ast_dump(ast\parse_code('<?php
    $x = 5;

    if ($x == 10) {
        return 5;
    } elseif ($x == 5) {
        if (true) {
            echo "ok";
        }
    }

    return;
 ?>', $version=30));
