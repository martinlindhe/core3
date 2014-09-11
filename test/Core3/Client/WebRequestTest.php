<?php
/**
 * @group Client
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $req = new \Core3\Client\WebRequest();

        $headers = array('User-Agent' => 'testbot 1.0');
        $response = $req->get('http://www.google.se', $headers);

        $this->assertInstanceOf('\Core3\Client\WebResponse', $response);

        $this->assertEquals(
            200,
            $response->httpCode
        );
    }
}
