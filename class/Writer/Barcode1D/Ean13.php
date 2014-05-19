<?php

class Writer_Barcode1D_Ean13 extends Writer_Barcode1D
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
