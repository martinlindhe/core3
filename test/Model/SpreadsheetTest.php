<?php
namespace Model;

/**
 * @group Model
 */
class SpreadsheetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Core3\Exception\InvalidArgument
     */
    function testDefineColumnsInvalid()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->defineColumns(4);
    }

    /**
     * @expectedException \Core3\Exception\InvalidArgument
     */
    function testAddRowInvalid()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->addRow(4);
    }

    /**
     * @expectedException \Core3\Exception\InvalidArgument
     */
    function testAddRowWrongColumns()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->defineColumns(array('c1','c2'));
        $model->addRow(array(1,2,3));
    }

    /**
     * @expectedException \Core3\Exception\InvalidArgument
     */
    function testSetFooterInvalid()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->setFooter(4);
    }
}
