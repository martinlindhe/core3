<?php

abstract class Writer_Barcode2D
{
	abstract public function renderAsHtml($code);
	abstract public function renderAsPng($code);

	protected function getAsHtml($code, $type)
	{
		$barcode = new TCPDF2DBarcode($code, $type);
		return $barcode->getBarcodeHTML(6, 6, 'black');
	}

	protected function getAsPng($code, $type)
	{
		$barcode = new TCPDF2DBarcode($code, $type);
		return $barcode->getBarcodePNGData(6, 6, array(0, 0, 0));
	}
}
