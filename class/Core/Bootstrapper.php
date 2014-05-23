<?php
namespace Core;

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
     */
    public static function bootstrap()
    {
        $vendorRoot = realpath(__DIR__.'/../../vendor');
        $tcpdfRoot = $vendorRoot.'/tecnick.com/tcpdf';

        require_once $tcpdfRoot.'/tcpdf.php';
        require_once $tcpdfRoot.'/tcpdf_barcodes_1d.php';
        require_once $tcpdfRoot.'/tcpdf_barcodes_2d.php';

        require_once $vendorRoot.'/ircmaxell/password-compat/lib/password.php';

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
