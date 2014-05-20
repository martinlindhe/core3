<?php
/**
 * @group Writer
 */

class Writer_SpreadsheetHtmlTest extends PHPUnit_Framework_TestCase
{
    function testUsage1()
    {
        // NOTE shows basic usage

        $model = new Model_Spreadsheet();
        $model->defineColumns(array('id', 'result'));
        $model->addRow(array(1, 200.57));
        $model->addRow(array(2, 319.11));

        $writer = new Writer_SpreadsheetXhtml();
        $writer->setClassName('css_class');

        $this->assertEquals(
            $writer->render($model),
            '<table class="css_class">'.
            '<tr><th>id</th><th>result</th></tr>'.
            '<tr><td>1</td><td>200.57</td></tr>'.
            '<tr><td>2</td><td>319.11</td></tr>'.
            '</table>'
        );
    }

    function testFooterColumn()
    {
        // NOTE tests that footer column colspan is calculated correctly

        $model = new Model_Spreadsheet();
        $model->defineColumns(array('id', 'name', 'result'));
        $model->addRow(array(1, 'a', 200.57));
        $model->addRow(array(2, 'b', 319.11));
        $model->setFooter(array('SUMMARY', 'TOTAL'));

        $writer = new Writer_SpreadsheetXhtml();

        $this->assertEquals(
            $writer->render($model),
            '<table class="htmlBox">'.
            '<tr><th>id</th><th>name</th><th>result</th></tr>'.
            '<tr><td>1</td><td>a</td><td>200.57</td></tr>'.
            '<tr><td>2</td><td>b</td><td>319.11</td></tr>'.
            '<tr><th colspan="2">SUMMARY</th><th>TOTAL</th></tr>'.
            '</table>'
        );
    }
}
