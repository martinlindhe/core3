<?php
$tcpdfRoot = realpath(__DIR__.'/../vendor/tecnick.com/tcpdf');

require_once $tcpdfRoot.'/tcpdf.php';
require_once $tcpdfRoot.'/tcpdf_barcodes_1d.php';
require_once $tcpdfRoot.'/tcpdf_barcodes_2d.php';

require_once realpath(__DIR__.'/../vendor/ircmaxell/password-compat/lib').'/password.php';

require_once __DIR__.'/XdebugExtras.php';



require_once realpath(__DIR__.'/../class/Core').'/Bootstrapper.php';

spl_autoload_register('Core_Bootstrapper::autoload');

Core_Bootstrapper::initTestingSettings();
