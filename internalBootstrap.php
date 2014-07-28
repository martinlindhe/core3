<?php

// register core3 composer autoloader
require_once __DIR__.'/vendor/autoload.php';

// register core3 autoloader
spl_autoload_register(function ($class) {
    $class = strtr($class, "\\", DIRECTORY_SEPARATOR);
    $fileName = __DIR__.'/class/'.$class.'.php';

    if (file_exists($fileName)) {
        include $fileName;
    }
});
