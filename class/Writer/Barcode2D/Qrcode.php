<?php

class Writer_Barcode2D_Qrcode extends Writer_Barcode2D
{
    public function renderAsHtml($code)
    {
        return parent::renderAsHtml($code, 'QRCODE,H');
    }

    public function renderAsPng($code)
    {
        return parent::renderAsPng($code, 'QRCODE,H');
    }
}
