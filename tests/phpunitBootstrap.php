<?php

function my_autoloader($className)
{
    $className = str_replace('_', '/', $className);

    $fileName = realpath(__DIR__ . '/../class') .'/'. $className . '.php';

    if (!file_exists($fileName)) {
        echo "CANT FIND: ".$fileName."\n";
        return false;
    }

    require_once ( $fileName );
}

spl_autoload_register('my_autoloader');

// path for debian installation of "php-tcpdf"
require_once('/usr/share/php/tcpdf/tcpdf.php');
