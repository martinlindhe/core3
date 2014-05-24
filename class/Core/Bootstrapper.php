<?php
namespace Core;

require_once 'Exceptions.php';

class Bootstrapper
{
    public static function autoload($class)
    {
        $class = strtr($class, "\\", DIRECTORY_SEPARATOR);

        $fileName = realpath(__DIR__.'/../').'/'.$class.'.php';

        if (file_exists($fileName)) {
            include $fileName;
        }
    }

    /**
     * Bootstraps the application
     * @codeCoverageIgnore
     */
    public static function bootstrap()
    {
        spl_autoload_register('Core\Bootstrapper::autoload');
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
