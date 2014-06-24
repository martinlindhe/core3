<?php

/**
 * @group Reader
 */
class ReaderCsvTest extends \PHPUnit_Framework_TestCase
{
    function testBasic()
    {
        $data = '"AAPL",357.05,357.01,194.06,360.00';

        $reader = new \Reader\Csv();
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(5, count($rows[0]));
        $this->assertEquals(array("AAPL",357.05,357.01,194.06,360.00), $rows[0]);
    }

    function testDelimiter()
    {
        $data = "a;b;c\n";

        $reader = new \Reader\Csv();
        $reader->setDelimiter(';');
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(3, count($rows[0]));
        $this->assertEquals(array('a', 'b', 'c'), $rows[0]);
    }

    function testIgnoreHeader()
    {
        $data =
        ";head a,head b, head c\n".
        "a,b,c\n";

        $reader = new \Reader\Csv();
        $reader->setStartLine(2);
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(3, count($rows[0]));
        $this->assertEquals(array('a', 'b', 'c'), $rows[0]);
    }
}
