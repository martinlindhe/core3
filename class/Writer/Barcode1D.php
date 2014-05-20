<?php

abstract class Writer_Barcode1D
{
	abstract public function renderAsHtml($code);
	abstract public function renderAsPng($code);

	protected function getHtml($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodeHTML(2, 30, 'black');
	}

	protected function getPng($code, $type)
	{
		$barcode = new TCPDFBarcode($code, $type);
		return $barcode->getBarcodePNGData(2, 30, array(0, 0, 0));
	}
}
