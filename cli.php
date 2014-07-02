#!/usr/bin/env php
<?php
/**
 * Invokes core3 application command line utils
 */

if (count($argv) < 2) {
    echo "Usage: <go to app root>\n";
    echo "  ".$argv[0]." scss-generate\n\n";
    die;
}

//XXX validate input
$cliViewFile = __DIR__.'/cli/'.$argv[1].'.php';

if (!file_exists($cliViewFile)) {
    echo "Invalid command";
    die;
}

include $cliViewFile;
