<?php
namespace Core3\Writer\Barcode1D;

class Ean13 extends \Core3\Writer\Barcode1D
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
