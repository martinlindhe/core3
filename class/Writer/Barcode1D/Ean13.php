<?php

class Writer_Barcode1D_Ean13 extends Writer_Barcode1D
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
