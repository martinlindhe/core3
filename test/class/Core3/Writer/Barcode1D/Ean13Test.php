<?php

/**
 * @group Writer
 */
class Ean13Test extends \PHPUnit_Framework_TestCase
{
    function testUsageHtml()
    {
        $writer = new \Core3\Writer\Barcode1D\Ean13();
        $data = $writer->renderAsHtml('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }

    function testUsagePng()
    {
        $writer = new \Core3\Writer\Barcode1D\Ean13();
        $data = $writer->renderAsPng('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));

        $reader = new \Core3\Reader\BinaryData\Image();
        $this->assertEquals(true, $reader->isPngData($data));
    }
}
