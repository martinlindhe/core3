<?php

class MyCsvColumn
{
    var $col1;
    var $col2;
    var $col3;
}
class CsvColumnFour
{
    var $c1;
    var $c2;
    var $c3;
    var $c4;
}

/**
 * @group Reader
 */
class ReaderCsvTest extends \PHPUnit_Framework_TestCase
{
    function testBasic()
    {
        $data = '"AAPL",357.05,357.01,194.06,360.00';

        $reader = new \Core3\Reader\Csv();
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(array('AAPL', 357.05, 357.01, 194.06, 360.00), $rows[0]);
    }

    function testEmptyColumns()
    {
        $data = 'a,,c,d,,';

        $reader = new \Core3\Reader\Csv();
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(array('a', '', 'c', 'd', '', ''), $rows[0]);
    }
    function testEscapedColumn()
    {
         $data = '"a""ha",b,c';

        $reader = new \Core3\Reader\Csv();
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(array('a"ha', 'b','c'), $rows[0]);
    }

    function testDelimiter()
    {
        $data = "a;b;c";

        $reader = new \Core3\Reader\Csv();
        $reader->setDelimiter(';');
        $rows = $reader->parse($data);

        $this->assertEquals(1, count($rows));
        $this->assertEquals(array('a', 'b', 'c'), $rows[0]);
    }

    function testIgnoreHeader()
    {
        $data =
        ";head a,head b, head c\n".
        "a,b,c\n".
        "d,e,f\n";

        $reader = new \Core3\Reader\Csv();
        $reader->setStartLine(2);
        $rows = $reader->parse($data);

        $this->assertEquals(2, count($rows));
        $this->assertEquals(array('a', 'b', 'c'), $rows[0]);
        $this->assertEquals(array('d', 'e', 'f'), $rows[1]);
    }

    function testToObject()
    {
        $data =
            "a,b,c\n".
            "1,2,3\n";

        $reader = new \Core3\Reader\Csv();
        $objs = $reader->parseToObjects($data, new MyCsvColumn());
        $this->assertEquals(2, count($objs));

        $ref = new MyCsvColumn();
        $ref->col1 = 'a';
        $ref->col2 = 'b';
        $ref->col3 = 'c';
        $this->assertEquals($ref, $objs[0]);

        $ref = new MyCsvColumn();
        $ref->col1 = '1';
        $ref->col2 = '2';
        $ref->col3 = '3';
        $this->assertEquals($ref, $objs[1]);
    }
}
