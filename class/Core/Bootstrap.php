<?php
namespace Core;

require_once __DIR__.'/../Exceptions.php';

class Bootstrap
{
    private static function autoload($class)
    {
        $class = strtr($class, "\\", DIRECTORY_SEPARATOR);

        $fileName = realpath(__DIR__.'/../').'/'.$class.'.php';

        if (file_exists($fileName)) {
            include $fileName;
        }
    }

    /**
     * Registers composer autoloader and our class autoloader
     * @codeCoverageIgnore
     */
    public static function registerAutoloader()
    {
        require_once __DIR__.'/../../vendor/autoload.php';

        spl_autoload_register('Core\Bootstrap::autoload');
    }

    /**
     * Test helper
     * @codeCoverageIgnore
     */
    public static function initTestingSettings()
    {
        ini_set('memory_limit', '256M');

        date_default_timezone_set('UTC');

        error_reporting(E_ALL | E_STRICT | E_DEPRECATED);
        ini_set('display_errors', 1);
        
        // tell php to stop modifying Content-Type header
        ini_set('default_charset', '');
    }
}
