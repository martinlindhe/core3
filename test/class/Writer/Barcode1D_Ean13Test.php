<?php
/**
 * @group Writer
 */
class Writer_Barcode1D_Ean13Test extends PHPUnit_Framework_TestCase
{
	function testUsageHtml()
	{
		$data = Writer_Barcode1D_Ean13::renderAsHtml('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}

	function testUsagePng()
    {
		$data = Writer_Barcode1D_Ean13::renderAsPng('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}
}
