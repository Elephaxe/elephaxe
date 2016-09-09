<?php

require '../php-ast/util.php';
require __DIR__ .'/test.php';
require __DIR__ .'/../vendor/autoload.php';

$parser = new \Elephaxe\Parser\FileParser(__DIR__.'/test.php');
die($parser->process());

// echo var_export(ast\parse_code('
//       print "Hello World";
//  ', $version=30), true);
//
// echo ast_dump(ast\parse_code('
//     <?php
//     if (true) {
//         print "Hello World";
//
//     }
//
//  ', $version=30));
