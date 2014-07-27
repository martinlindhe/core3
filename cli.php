#!/usr/bin/env php
<?php
/**
 * Invokes core3 application command line utils
 */

require 'internalBootstrap.php';

$router = new \Cli\ApplicationRouter();

if (count($argv) < 2) {
    echo "Usage: <go to app root>\n";
    $router->printAvailableRoutes($argv[0]);
    die;
}

try {
    $router->route($argv[1]);
} catch (\Exception $ex) {
    echo "Error: ".$ex."\n";
}
