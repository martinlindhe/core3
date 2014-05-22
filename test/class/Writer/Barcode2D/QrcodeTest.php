<?php
namespace Writer\Barcode2D;

/**
 * @group Writer
 */
class QrcodeTest extends \PHPUnit_Framework_TestCase
{
    function testUsageHtml()
    {
        $writer = new Qrcode();
        $data = $writer->renderAsHtml('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }

    function testUsagePng()
    {
        $writer = new Qrcode();
        $data = $writer->renderAsPng('hello world :-)');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));

        $reader = new \Reader\BinaryData\Image();
        $this->assertGreaterThanOrEqual(true, $reader->isPngData($data));
    }
}
