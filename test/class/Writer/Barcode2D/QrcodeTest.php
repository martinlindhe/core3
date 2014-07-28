<?php

/**
 * @group Writer
 */
class QrcodeTest extends \PHPUnit_Framework_TestCase
{
    function testUsageHtml()
    {
        $writer = new \Core3\Writer\Barcode2D\Qrcode();
        $data = $writer->renderAsHtml('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }

    function testUsagePng()
    {
        $writer = new \Core3\Writer\Barcode2D\Qrcode();
        $data = $writer->renderAsPng('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));

        $reader = new \Core3\Reader\BinaryData\Image();
        $this->assertEquals(true, $reader->isPngData($data));
    }
}
