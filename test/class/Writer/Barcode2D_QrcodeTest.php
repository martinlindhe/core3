<?php
/**
 * @group Writer
 */
class Writer_Barcode2D_QrcodeTest extends PHPUnit_Framework_TestCase
{
	function testUsageHtml()
	{
		$data = Writer_Barcode2D_Qrcode::renderAsHtml('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}

	function testUsagePng()
    {
		$data = Writer_Barcode2D_Qrcode::renderAsPng('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
	}
}
