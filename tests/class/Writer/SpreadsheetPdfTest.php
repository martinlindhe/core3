<?php

// TODO use real model
class Model_Spreadsheet
{
    var $columns = array();
    var $rows = array();
}

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

        // TODO  verify generated output, using pdf reader class (?)
    }

}
