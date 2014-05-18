<?php

function my_autoloader($className)
{
    $fileName = realpath(__DIR__ . '/../class') .'/'. str_replace('_', '/', $className) . '.php';
    if (file_exists($fileName)) {
        require_once($fileName);
    }

}

// path for debian installation of "php-tcpdf"
require_once('/usr/share/php/tcpdf/tcpdf.php');

spl_autoload_register('my_autoloader', true, false);

