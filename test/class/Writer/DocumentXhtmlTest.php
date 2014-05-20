<?php
// NOTE: for header() testing to work, we must run phpunit with --stderr

/**
 * @group Writer
 */

class Writer_DocumentXhtmlTest extends PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
    {
        $writer = new Writer_DocumentXhtml();
        $writer->sendHttpHeaders();

        $this->assertEquals(array('text/html; charset=utf-8'), XdebugExtras::findHeaders('Content-Type'));
    }

    function testUsageExample()
    {
        $writer = new Writer_DocumentXhtml();
        $data = $writer->render();

        //$this->markTestIncomplete('TODO finish test');
    }

}
