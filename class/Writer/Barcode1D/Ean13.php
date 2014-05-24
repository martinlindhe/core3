<?php
namespace Writer\Barcode1D;

$tcpdfRoot = realpath(__DIR__.'/../../../vendor/tecnick.com/tcpdf');
require_once $tcpdfRoot.'/tcpdf_barcodes_1d.php';

class Ean13 extends \Writer\Barcode1D
{
    public function renderAsHtml($code)
    {
        return parent::getHtml($code, 'EAN13');
    }

    public function renderAsPng($code)
    {
        return parent::getPng($code, 'EAN13');
    }
}
