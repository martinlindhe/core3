<?php
/**
 * @group Client
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $req = new \Client\WebRequest();
        
        $headers = array('User-Agent' => 'testbot 1.0');
        $response = $req->get('http://www.google.se', $headers);

        $this->assertInstanceOf('\Client\WebResponse', $response);

        $this->assertEquals(
            200,
            $response->httpCode
        );
    }
}
