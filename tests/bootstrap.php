<?php

function my_autoloader($className)
{
    $className = str_replace('_', '/', $className);

    $fileName = realpath(__DIR__ . '/../class') .'/'. $className . '.php';
    if (file_exists($fileName)) {
        require_once($fileName);
        return true;
    }

    return false;
}

spl_autoload_register('my_autoloader');

// path for debian installation of "php-tcpdf"
require_once('/usr/share/php/tcpdf/tcpdf.php');
