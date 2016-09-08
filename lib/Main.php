<?php

require '../php-ast/util.php';

echo var_export(ast\parse_code('
      print "Hello World";
 ', $version=30), true);

echo ast_dump(ast\parse_code('
    <?php 
    if (true) {
        print "Hello World";

    }
    ?>
 ', $version=30));
