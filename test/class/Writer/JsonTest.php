<?php

/**
 * @group Writer
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{
    function testBasic()
    {
        $o = new stdClass();
        $o->name = "hej";
        $o->vals = array(1,2,3);

        $this->assertEquals(
            '{"name":"hej","vals":[1,2,3]}',
            \Writer\Json::encode($o)
        );
    }

    function testEncodeUnicode()
    {
        $o = new stdClass();
        $o->name = "höj";

        $this->assertEquals(
            '{"name":"h\u00f6j"}',
            \Writer\Json::encode($o)
        );
    }

    function testEncodeSlimUnicode()
    {
        $o = new stdClass();
        $o->name = "höj";

        $this->assertEquals(
            '{"name":"höj"}',
            \Writer\Json::encodeSlim($o)
        );
    }

    function testEncodeSlimSlashes()
    {
        $o = new stdClass();
        $o->name = "path/to/file";

        $this->assertEquals(
            '{"name":"path/to/file"}',
            \Writer\Json::encodeSlim($o)
        );
    }
    
    
    function testEncodeSlashes()
    {
        $o = new stdClass();
        $o->name = "path/to/file";

        $this->assertEquals(
            '{"name":"path\/to\/file"}',
            \Writer\Json::encode($o)
        );
    }
}