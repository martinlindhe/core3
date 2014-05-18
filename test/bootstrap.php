<?php

function my_autoloader($className)
{
    $fileName = realpath(__DIR__ . '/../class') .'/'. str_replace('_', '/', $className) . '.php';
    if (file_exists($fileName)) {
        require_once($fileName);
    }
}

require_once( realpath(__DIR__ . '/../lib') . '/tcpdf/tcpdf.php');
require_once( realpath(__DIR__ . '/../lib') . '/password_compat/password.php');

spl_autoload_register('my_autoloader');

// php config required for tests
ini_set('memory_limit', '256M');

date_default_timezone_set('UTC');
