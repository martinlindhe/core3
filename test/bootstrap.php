<?php

// register core3 autoloader
spl_autoload_register(function ($class)
{
    $class = strtr($class, "\\", DIRECTORY_SEPARATOR);
    $fileName = __DIR__.'/../class/'.$class.'.php';

    if (file_exists($fileName)) {
        include $fileName;
    }
});


ini_set('memory_limit', '256M');

date_default_timezone_set('UTC');

error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
ini_set('display_errors', 1);

// tell php to stop modifying Content-Type header
ini_set('default_charset', '');
