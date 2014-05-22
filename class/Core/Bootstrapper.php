<?php
namespace Core;

class Bootstrapper
{
    public static function autoload($class)
    {
        $class = strtr($class, "\\", DIRECTORY_SEPARATOR);

        $fileName = realpath(__DIR__.'/../').'/'.$class.'.php';
        echo "loading ".$fileName;

        if (file_exists($fileName)) {
            echo " - YES!\n";
            include $fileName;
        } else {
            echo " - no\n";
        }
    }

    /**
     * unit test helper
     * @codeCoverageIgnore
     */
    public static function initTestingSettings()
    {
        ini_set('memory_limit', '256M');

        date_default_timezone_set('UTC');

        error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
        ini_set('display_errors', 1);
    }
}
