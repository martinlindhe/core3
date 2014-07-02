#!/usr/bin/env php
<?php
/**
 * Invokes core3 application command line utils
 */

require 'bootstrap.php';

if (count($argv) < 2) {
    echo "Usage: <go to app root>\n";
    // TODO iterate over available cli views in core3 & app folders 
    echo "  ".$argv[0]." scss-generate   [core]\n\n";
    die;
}

//XXX validate input
$cliViewFile = __DIR__.'/cli/'.$argv[1].'.php';

if (!file_exists($cliViewFile)) {
    echo "Invalid command";
    die;
}

include $cliViewFile;
