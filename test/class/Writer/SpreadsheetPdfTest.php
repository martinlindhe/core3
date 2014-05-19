<?php
/**
 * @group Writer
 */

class Writer_SpreadsheetPdfTest extends PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
    {
        // NOTE: for header() testing to work, we must run phpunit with --stderr

        $fileName = 'file_'.mt_rand().'.pdf';
        Writer_SpreadsheetPdf::sendHttpAttachmentHeaders($fileName);

        $this->assertEquals( array('application/pdf'), xdebug_find_headers('Content-Type'));
        $this->assertEquals( array('attachment; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
        $this->assertEquals( array('no-cache'), xdebug_find_headers('Pragma'));
        $this->assertEquals( array('0'), xdebug_find_headers('Expires'));
    }

    function testUsageExample()
    {
        $model = new Model_Spreadsheet();
        $model->defineColumns( array('id', 'name') );
        $model->addRow( array('1', 'kalle') );
        $model->addRow( array('2', 'olle') );

        $writer = new Writer_SpreadsheetPdf();
        $writer->setCreator('custom framework 1.0');
        $writer->setAuthor('Mr Cool');
        $writer->setTitle('Document title');
        $writer->setSubject('Document subject');
        $writer->addKeywords( array('cool', 'stuff', 'testing') );
        $data = $writer->render($model);

        $this->assertGreaterThan( 1000, strlen($data), 'Some data was returned' );

        // file_put_contents('out.pdf', $data);

        // TODO: verify generated document, requires PDF & PS Readers
    }

}
