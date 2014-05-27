<?php
namespace Writer;

// NOTE: for header() testing to work, we must run phpunit with --stderr

/**
 * @group Writer
 */
class DocumentXhtmlTest extends \PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
    {
        $writer = new DocumentXhtml();
        $writer->sendHttpHeaders();

        $this->assertEquals(array('text/html; charset=utf-8'), \Debug\XdebugExtras::findHeaders('Content-Type'));
    }

}
