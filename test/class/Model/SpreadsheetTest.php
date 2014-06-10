<?php
namespace Model;

/**
 * @group Model
 */
class SpreadsheetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    function testDefineColumnsInvalid()
    {
        $model = new \Model\Spreadsheet();
        $model->defineColumns(4);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testAddRowInvalid()
    {
        $model = new \Model\Spreadsheet();
        $model->addRow(4);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testAddRowWrongColumns()
    {
        $model = new \Model\Spreadsheet();
        $model->defineColumns(array('c1','c2'));
        $model->addRow(array(1,2,3));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    function testSetFooterInvalid()
    {
        $model = new \Model\Spreadsheet();
        $model->setFooter(4);
    }
}
