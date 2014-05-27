<?php
namespace Writer\Barcode2D;

require_once realpath(__DIR__.'/../../../vendor/tecnick.com/tcpdf').'/tcpdf_barcodes_2d.php';

class Qrcode extends \Writer\Barcode2D
{
    public function renderAsHtml($code)
    {
        return parent::getAsHtml($code, 'QRCODE,H');
    }

    public function renderAsPng($code)
    {
        return parent::getAsPng($code, 'QRCODE,H');
    }
}
