<?php
/**
 * @group Client
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase
{
	function test1()
	{
		$data = \Client\WebRequest::get('http://www.google.se');
		
		var_dump($data);
	}
}