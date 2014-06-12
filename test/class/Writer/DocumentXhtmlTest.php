<?php
namespace Writer;

/**
 * @group Writer
 */
class DocumentXhtmlTest extends \PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
    {
        $writer = new DocumentXhtml();
        $writer->sendHttpHeaders();

        $this->assertEquals(
            array('text/html; charset=utf-8'),
            \Debug\XdebugExtras::findHeaders('Content-Type')
        );
    }
}
