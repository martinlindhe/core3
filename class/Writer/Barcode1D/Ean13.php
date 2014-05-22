<?php
namespace Writer\Barcode1D;

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
