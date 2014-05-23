<?php
namespace Writer;
// NOTE: for header() testing to work, we must run phpunit with --stderr

/**
 * @group Writer
 */
class HttpHeaderTest extends \PHPUnit_Framework_TestCase
{
    function testContentType()
    {
        $header = new HttpHeader();
        $header->sendContentType('text/custom');

        $this->assertEquals(
            array('text/custom'),
            \Debug\XdebugExtras::findHeaders('Content-Type')
        );
    }

    function testFileAttachment()
    {
        $fileName = 'file_'.mt_rand().'.ext';

        $header = new HttpHeader();
        $header->sendAttachment($fileName);

        $this->assertEquals(
            array('attachment; filename="'.$fileName.'"'),
            \Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testFileAttachmentBasename()
    {
        // verifies that path is stripped from filename in Content-Disposition header
        $fileName = '/path/to/file_'.mt_rand().'.ext';

        $header = new HttpHeader();
        $header->sendAttachment($fileName);

        $this->assertEquals(
            array('attachment; filename="'.basename($fileName).'"'),
            \Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testFileInline()
    {
        $fileName = 'file_'.mt_rand().'.ext';

        $header = new HttpHeader();
        $header->sendInline($fileName);

        $this->assertEquals(
            array('inline; filename="'.$fileName.'"'),
            \Debug\XdebugExtras::findHeaders('Content-Disposition')
        );
    }

    function testNoCache()
    {
        $header = new HttpHeader();
        $header->sendNoCacheHeaders();

        $this->assertEquals(
            array('no-cache'),
            \Debug\XdebugExtras::findHeaders('Pragma')
        );

        $this->assertEquals(
            array('Sat, 26 Jul 1997 05:00:00 GMT'),
            \Debug\XdebugExtras::findHeaders('Expires')
        );
    }

    function testContentSecurityPolicy()
    {
        $header = new HttpHeader();
        $header->sendContentSecurityPolicy("default-src 'self'");

        $this->assertEquals(
            array("default-src 'self'"),
            \Debug\XdebugExtras::findHeaders('Content-Security-Policy')
        );
    }

    function testContentSecurityPolicyReportOnly()
    {
        $header = new HttpHeader();
        $header->sendContentSecurityPolicyReportOnly("default-src 'self'");

        $this->assertEquals(
            array("default-src 'self'"),
            \Debug\XdebugExtras::findHeaders('Content-Security-Policy-Report-Only')
        );
    }

    function testFrameOptions()
    {
        $header = new HttpHeader();
        $header->sendFrameOptions('DENY');

        $this->assertEquals(
            array('DENY'),
            \Debug\XdebugExtras::findHeaders('X-Frame-Options')
        );
    }
}
