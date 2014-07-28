<?php

/**
 * @group HhvmIncompatible
 * @group Writer
 */
class HttpHeaderTest extends \PHPUnit_Framework_TestCase
{
    function testContentType()
    {
        $header = new \Core3\Writer\HttpHeader();
        $header->sendContentType('text/custom');

        $this->assertEquals(
            array('text/custom'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Type')
        );
    }

    function testFileAttachment()
    {
        $fileName = 'file_'.mt_rand().'.ext';

        $header = new \Core3\Writer\HttpHeader();
        $header->sendAttachment($fileName);

        $this->assertEquals(
            array('attachment; filename="'.$fileName.'"'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testFileAttachmentBasename()
    {
        // verifies that path is stripped from filename in Content-Disposition header
        $fileName = '/path/to/file_'.mt_rand().'.ext';

        $header = new \Core3\Writer\HttpHeader();
        $header->sendAttachment($fileName);

        $this->assertEquals(
            array('attachment; filename="'.basename($fileName).'"'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testFileInline()
    {
        $fileName = 'file_'.mt_rand().'.ext';

        $header = new \Core3\Writer\HttpHeader();
        $header->sendInline($fileName);

        $this->assertEquals(
            array('inline; filename="'.$fileName.'"'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testNoCache()
    {
        $header = new \Core3\Writer\HttpHeader();
        $header->sendNoCacheHeaders();

        $this->assertEquals(
            array('no-cache'),
            \Core3\Debug\XdebugExtras::findHeaders('Pragma')
        );

        $this->assertEquals(
            array('Sat, 26 Jul 1997 05:00:00 GMT'),
            \Core3\Debug\XdebugExtras::findHeaders('Expires')
        );
    }

    function testContentSecurityPolicy()
    {
        $header = new \Core3\Writer\HttpHeader();
        $header->sendContentSecurityPolicy("default-src 'self'");

        $this->assertEquals(
            array("default-src 'self'"),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Security-Policy')
        );
    }

    function testContentSecurityPolicyReportOnly()
    {
        $header = new \Core3\Writer\HttpHeader();
        $header->sendContentSecurityPolicyReportOnly("default-src 'self'");

        $this->assertEquals(
            array("default-src 'self'"),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Security-Policy-Report-Only')
        );
    }

    function testFrameOptions()
    {
        $header = new \Core3\Writer\HttpHeader();
        $header->sendFrameOptions('DENY');

        $this->assertEquals(
            array('DENY'),
            \Core3\Debug\XdebugExtras::findHeaders('X-Frame-Options')
        );
    }
}
