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
class JsonTest extends \PHPUnit_Framework_TestCase
{
    function testBasicUsage()
    {
        /*
        $row1 = new RowFormat();
        $row1->id = 1;
        $row1->name = "mr mr";
        $row1->decimalNumber = 3.14;
        $row1->datestamp = "2014-04-26 11:13:21";

        $row2 = new RowFormat();
        $row2->id = 2;
        $row2->name = "oteth";
        $row2->decimalNumber = 5.559;
        $row2->datestamp = "2014-05-01 12:00:00";

        $row3 = new RowFormat();
        $row3->id = 3;
        $row3->name = "smtmhm";
        $row3->decimalNumber = 1;
        $row3->datestamp = "2014-05-20 18:00:00";
*/
        $model = new Model\Spreadsheet();
        $model->addRow(array(37, 'hej', '2000-05-05'));
        $model->addRow(array(11, 'vö rääå', '2010-12-31'));
        //$model->addRows(array($row1, $row2, $row3));

        $writer = new Writer\Spreadsheet\Json();

        $this->assertEquals(
            '[[37,"hej","2000-05-05"],[11,"vö rääå","2010-12-31"]]',
            $writer->render($model)
        );
    }

/*
    function testUseObjects()
    {
        // TODO Model\Spreadsheet need to support objects

        $row1 = new RowFormat();
        $row1->id = 1;
        $row1->name = "mr mr";
        $row1->decimalNumber = 3.14;
        $row1->datestamp = "2014-04-26 11:13:21";

        $row2 = new RowFormat();
        $row2->id = 2;
        $row2->name = "oteth";
        $row2->decimalNumber = 5.559;
        $row2->datestamp = "2014-05-01 12:00:00";

        $row3 = new RowFormat();
        $row3->id = 3;
        $row3->name = "smtmhm";
        $row3->decimalNumber = 1;
        $row3->datestamp = "2014-05-20 18:00:00";

        $model = new Model\Spreadsheet();
        $model->addRows(array($row1, $row2, $row3));

        $writer = new Writer\Spreadsheet\Json();

        $this->assertEquals(
            '[[37,"hej","2000-05-05"],[11,"vö rääå","2010-12-31"]]',
            $writer->render($model)
        );
    }
*/
}
