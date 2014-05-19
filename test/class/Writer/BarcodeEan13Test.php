<?php
/**
 * @group Writer
 */
class Writer_BarcodeEan13Test extends PHPUnit_Framework_TestCase
{
	function testUsageHtml()
	{
		$data = Writer_BarcodeEAN13::renderAsHtml('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}

	function testUsagePng()
    {
		$data = Writer_BarcodeEAN13::renderAsPng('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}
}
