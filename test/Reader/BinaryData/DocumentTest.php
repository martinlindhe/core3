<?php

/**
 * @group Reader
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{
    function testRecognizePdf()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->defineColumns(array('name'));
        $model->addRow(array('kalle'));

        $writer = new \Core3\Writer\Spreadsheet\Pdf();
        $data = $writer->render($model);

        $reader = new \Core3\Reader\BinaryData\Document();

        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isPdfData($data));
    }

    function testUnrecognizedData()
    {
        $data = str_repeat(chr(0x12).chr(0x13).chr(0xFF).chr(0x20), 500);

        $reader = new \Core3\Reader\BinaryData\Document();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPdfData($data));
    }

    function testUnrecognizedTinyData()
    {
        $data = chr(0x12).chr(0x13).chr(0xFF).chr(0x20);

        $reader = new \Core3\Reader\BinaryData\Document();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPdfData($data));
    }

}
