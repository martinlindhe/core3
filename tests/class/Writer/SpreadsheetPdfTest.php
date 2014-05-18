<?php
/**
 * @group Writer
 */

class Writer_SpreadsheetPdfTest extends PHPUnit_Framework_TestCase
{
    function testUsageExample()
    {
        // TODO fix class to actually render the SpreadsheetModel
        $model = new Model_Spreadsheet();

        $model->columns = array('id', 'name');
        $model->rows[] = array('1', 'kalle');
        $model->rows[] = array('2', 'olle');


        $writer = new Writer_SpreadsheetPdf();
        $data = $writer->render($model);

        $this->assertGreaterThan( 1000, strlen($data), 'Some data was returned' );

        //$this->markTestIncomplete('TODO  verify generated output');
    }

}
