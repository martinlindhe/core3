<?php

// TODO BUG waiting for resolve: https://sourceforge.net/p/tcpdf/bugs/921/
// TODO feature waiting for merge: https://sourceforge.net/p/tcpdf/patches/70/
//$tcpdfRoot = realpath(__DIR__.'/../vendor/tecnick.com/tcpdf'); // XXX TODO, tcpdf-trunk is broken 2014-05-20
$tcpdfRoot = realpath(__DIR__.'/../lib').'/tcpdf';

require_once $tcpdfRoot.'/tcpdf.php';
require_once $tcpdfRoot.'/tcpdf_barcodes_1d.php';
require_once $tcpdfRoot.'/tcpdf_barcodes_2d.php';

require_once realpath(__DIR__.'/../vendor/ircmaxell/password-compat/lib').'/password.php';

require_once __DIR__.'/XdebugExtras.php';
require_once __DIR__.'/Bootstrapper.php';

spl_autoload_register('Bootstrapper::autoload');

Bootstrapper::initTestingSettings();
