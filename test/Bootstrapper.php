<?php

class Bootstrapper
{
    public static function autoload($className)
    {
        $fileName = realpath(__DIR__ . '/../class') .'/'. str_replace('_', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }

    /**
     * php config required for tests
     */
    public static function initTestingSettings()
    {
        ini_set('memory_limit', '256M');

        date_default_timezone_set('UTC');

        error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
        ini_set('display_errors', 1);
    }
}
