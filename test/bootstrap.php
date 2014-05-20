<?php

require_once realpath(__DIR__.'/../lib').'/tcpdf/tcpdf.php';
require_once realpath(__DIR__.'/../lib').'/tcpdf/tcpdf_barcodes_1d.php';
require_once realpath(__DIR__.'/../lib').'/tcpdf/tcpdf_barcodes_2d.php';
require_once realpath(__DIR__.'/../lib').'/password_compat/password.php';

require_once __DIR__.'/XdebugExtras.php';
require_once __DIR__.'/Bootstrapper.php';

spl_autoload_register('Bootstrapper::autoload');

Bootstrapper::initTestingSettings();
