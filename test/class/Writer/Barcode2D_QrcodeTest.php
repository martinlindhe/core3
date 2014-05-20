<?php
/**
 * @group Writer
 */
class Writer_Barcode2D_QrcodeTest extends PHPUnit_Framework_TestCase
{
    function testUsageHtml()
    {
        $writer = new Writer_Barcode2D_Qrcode();
        $data = $writer->renderAsHtml('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }

    function testUsagePng()
    {
        $writer = new Writer_Barcode2D_Qrcode();
        $data = $writer->renderAsPng('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }
}
