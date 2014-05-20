<?php
/**
 * @group Writer
 */
class Writer_Barcode1D_Ean13Test extends PHPUnit_Framework_TestCase
{
    function testUsageHtml()
    {
        $writer = new Writer_Barcode1D_Ean13();
        $data = $writer->renderAsHtml('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));
    }

    function testUsagePng()
    {
        $writer = new Writer_Barcode1D_Ean13();
        $data = $writer->renderAsPng('7310500078045');

        $this->assertInternalType('string', $data);
        $this->assertGreaterThanOrEqual(100, strlen($data));

        $reader = new Reader_BinaryData_Image();
        $this->assertGreaterThanOrEqual(true, $reader->isPngData($data));
    }
}
