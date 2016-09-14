<?php
use Elephaxe\Parser\ParserException;

require '../php-ast/util.php';
require __DIR__ .'/test.php';
require __DIR__ .'/../vendor/autoload.php';

$parser = new \Elephaxe\Parser\FileParser(__DIR__.'/test.php');
try {
    die($parser->process());
} catch (ParserException $ex) {
    die(var_dump($ex->getErrors()));
}

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
