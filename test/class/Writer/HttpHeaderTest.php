<?php
// NOTE: for header() testing to work, we must run phpunit with --stderr

/**
 * @group Writer
 */
class Writer_HttpHeaderTest extends PHPUnit_Framework_TestCase
{
    function testContentType()
    {
        $header = new Writer_HttpHeader();
        $header->sendContentType('text/custom');

        $this->assertEquals( array('text/custom'), xdebug_find_headers('Content-Type'));
    }

    function testAttachment()
    {
        $fileName = 'file_'.mt_rand().'.ext';

        $header = new Writer_HttpHeader();
        $header->sendAttachment($fileName);

        $this->assertEquals( array('attachment; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
    }

    function testNoCache()
    {
        $header = new Writer_HttpHeader();
        $header->sendNoCacheHeaders();

        $this->assertEquals( array('no-cache'), xdebug_find_headers('Pragma'));
        $this->assertEquals( array('Sat, 26 Jul 1997 05:00:00 GMT'), xdebug_find_headers('Expires'));
    }
}
