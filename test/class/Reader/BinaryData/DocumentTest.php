<?php
/**
 * @group Reader
 */

class Reader_BinaryData_DocumentTest extends PHPUnit_Framework_TestCase
{
    function testRecognizePdf()
    {
        $model = new Model_Spreadsheet();
        $model->defineColumns(array('name'));
        $model->addRow(array('kalle'));

        $writer = new Writer_Spreadsheet_Pdf();
        $data = $writer->render($model);

        $reader = new Reader_BinaryData_Document();

        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isPdfData($data));
    }

    function testUnrecognizedData()
    {
        $data = str_repeat(chr(0x12).chr(0x13).chr(0xFF).chr(0x20), 500);

        $reader = new Reader_BinaryData_Document();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPdfData($data));
    }

    function testUnrecognizedTinyData()
    {
        $data = chr(0x12).chr(0x13).chr(0xFF).chr(0x20);

        $reader = new Reader_BinaryData_Document();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPdfData($data));
    }

}
