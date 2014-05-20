<?php
// NOTE: for header() testing to work, we must run phpunit with --stderr

/**
 * @group Writer
 */

class Writer_DocumentXhtmlTest extends PHPUnit_Framework_TestCase
{
	function testHttpHeaders()
	{
		Writer_DocumentXhtml::sendHttpHeaders();

		$this->assertEquals( array('text/html; charset=utf-8'), xdebug_find_headers('Content-Type'));
	}

	function testUsageExample()
	{
		$writer = new Writer_DocumentXhtml();
		$data = $writer->render($model);

		//$this->markTestIncomplete('TODO finish test');
	}

}
