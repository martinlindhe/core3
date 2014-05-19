<?php

abstract class Writer_Barcode2D
{
	public function renderAsHtml($code, $type)
	{
		$barcode = new TCPDF2DBarcode($code, $type);
		return $barcode->getBarcodeHTML(6, 6, 'black');
	}

	public function renderAsPng($code, $type)
	{
		$barcode = new TCPDF2DBarcode($code, $type);
		return $barcode->getBarcodePNGData(6, 6, array(0, 0, 0));
	}
}
