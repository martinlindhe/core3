<?php

abstract class Writer_Barcode
{
	public function renderAsHtml($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodeHTML(2, 30, 'black');
	}

	public function renderAsPng($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodePNG(2, 30, array(0, 0, 0));
	}
}
