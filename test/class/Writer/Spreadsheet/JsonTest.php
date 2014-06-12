<?php

/**
 * @group Writer
 */
class RowFormat
{
    var $id;
    var $name;
    var $decimalNumber;
    var $datestamp;
}


/**
 * @group Writer
 */
class JsonSpreadsheetTest extends \PHPUnit_Framework_TestCase
{
    function testBasicUsage()
    {
        $model = new Model\Spreadsheet();
        $model->addRow(array(37, 'hej', '2000-05-05'));
        $model->addRow(array(11, 'vö rääå', '2010-12-31'));

        $writer = new Writer\Spreadsheet\Json();

        $this->assertEquals(
            '[[37,"hej","2000-05-05"],[11,"vö rääå","2010-12-31"]]',
            $writer->render($model)
        );
    }

    function testUseObjects()
    {
        // NOTE tests the use of objects

        $rowOne = new RowFormat();
        $rowOne->id = 1;
        $rowOne->name = "mr mr";
        $rowOne->decimalNumber = 3.14;
        $rowOne->datestamp = "2014-04-26 11:13:21";

        $rowTwo = new RowFormat();
        $rowTwo->id = 2;
        $rowTwo->name = "oteth";
        $rowTwo->decimalNumber = 5.559;
        $rowTwo->datestamp = "2014-05-01 12:00:00";

        $model = new Model\Spreadsheet();
        $model->addRows(array($rowOne, $rowTwo));

        $writer = new Writer\Spreadsheet\Json();

        $this->assertEquals(
            '['.
            '{"id":1,"name":"mr mr","decimalNumber":3.14,"datestamp":"2014-04-26 11:13:21"},'.
            '{"id":2,"name":"oteth","decimalNumber":5.559,"datestamp":"2014-05-01 12:00:00"}'.
            ']',
            $writer->render($model)
        );
    }

}
