<?php

/**
 * @group Reader
 */
class ReaderCsvTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $data = '"AAPL",357.05,357.01,194.06,360.00';

        $reader = new \Reader\Csv();
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(5, count($rows[0]));
        $this->assertEquals(array("AAPL",357.05,357.01,194.06,360.00), $rows[0]);
    }
}
