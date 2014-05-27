<?php
namespace Writer\Barcode1D;

require_once realpath(__DIR__.'/../../../vendor/tecnick.com/tcpdf').'/tcpdf_barcodes_1d.php';

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
