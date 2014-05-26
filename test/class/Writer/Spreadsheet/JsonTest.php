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
    function testEscapedStringContainsLineFeed()
    {
        echo "WOWW";
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

        $rows = array(
            $row1, $row2, $row3
        );

        echo json_encode($rows);

        $writer = new Writer\Spreadsheet\Json();

    }
}
