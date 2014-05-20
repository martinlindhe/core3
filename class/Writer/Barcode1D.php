<?php

abstract class Writer_Barcode1D
{
	public function renderAsHtml($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodeHTML(2, 30, 'black');
	}

	public function renderAsPng($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodePNGData(2, 30, array(0, 0, 0));
	}
}