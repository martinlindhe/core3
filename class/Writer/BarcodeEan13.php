<?php

class Writer_BarcodeEan13 extends Writer_Barcode
{
    public function renderAsHtml($code)
    {
        return parent::renderAsHtml($code, 'EAN13');
    }

    public function renderAsPng($code)
    {
        return parent::renderAsPng($code, 'EAN13');
    }
}
