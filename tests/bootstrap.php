<?php

function my_autoloader($className)
{
    $fileName = realpath(__DIR__ . '/../class') .'/'. str_replace('_', '/', $className) . '.php';
    if (file_exists($fileName)) {
        require_once($fileName);
    }

    if ($className == 'tcpdf') {
        // HACK blergh
        include('/usr/share/php/tcpdf/tcpdf.php');
    }
}

/*
set_include_path(
    '.' . PATH_SEPARATOR .
    '/usr/share/php/tcpdf/'         // path for debian installation of "php-tcpdf"
);
*/

spl_autoload_register('my_autoloader', true, false);

