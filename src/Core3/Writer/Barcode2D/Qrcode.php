<?php
namespace Core3\Writer\Barcode2D;

class Qrcode extends \Core3\Writer\Barcode2D
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
