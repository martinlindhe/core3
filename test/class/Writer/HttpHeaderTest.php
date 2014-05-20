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

	function testFileAttachment()
	{
		$fileName = 'file_'.mt_rand().'.ext';

		$header = new Writer_HttpHeader();
		$header->sendAttachment($fileName);

		$this->assertEquals( array('attachment; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
	}

	function testFileInline()
	{
		$fileName = 'file_'.mt_rand().'.ext';

		$header = new Writer_HttpHeader();
		$header->sendInline($fileName);

		$this->assertEquals( array('inline; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
	}

	function testNoCache()
	{
		$header = new Writer_HttpHeader();
		$header->sendNoCacheHeaders();

		$this->assertEquals( array('no-cache'), xdebug_find_headers('Pragma'));
		$this->assertEquals( array('Sat, 26 Jul 1997 05:00:00 GMT'), xdebug_find_headers('Expires'));
	}

	function testContentSecurityPolicy()
	{
		$header = new Writer_HttpHeader();
		$header->sendContentSecurityPolicy("default-src 'self'");

		$this->assertEquals( array("default-src 'self'"), xdebug_find_headers('Content-Security-Policy'));
	}

	function testContentSecurityPolicyReportOnly()
	{
		$header = new Writer_HttpHeader();
		$header->sendContentSecurityPolicyReportOnly("default-src 'self'");

		$this->assertEquals( array("default-src 'self'"), xdebug_find_headers('Content-Security-Policy-Report-Only'));
	}

	function testFrameOptions()
	{
		$header = new Writer_HttpHeader();
		$header->sendFrameOptions('DENY');

		$this->assertEquals( array('DENY'), xdebug_find_headers('X-Frame-Options'));
	}

}
