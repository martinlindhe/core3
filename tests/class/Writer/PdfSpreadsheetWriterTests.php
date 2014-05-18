<?php

// TODO use real model
class SpreadsheetModel
{
    var $columns = array();
    var $rows = array();
}

class PdfSpreadsheetWriterTests extends PHPUnit_Framework_TestCase
{
    function testUsageExample()
    {
        // TODO fix class to actually render the SpreadsheetModel
        $model = new SpreadsheetModel();

        $model->columns = array('id', 'name');
        $model->rows[] = array('1', 'kalle');
        $model->rows[] = array('2', 'olle');


        $writer = new PdfSpreadsheetWriter();
        $data = $writer->render($model);

        // TODO  verify generated output, using pdf reader class (?)
    }


}
