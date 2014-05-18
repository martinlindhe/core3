<?php
/**
 * PHPUnit bootstrap file
 */

// path for debian installation of "php-tcpdf"
require_once('/usr/share/php/tcpdf/tcpdf.php');

function __autoload($class_name)
{
    var_dump($class_name);
    echo "__AUTOLOAD WORKING... \n";

    require_once $class_name . '.php';
}
