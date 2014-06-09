<?php
/**
 * @group Client
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $req = new \Client\WebRequest();
        $response = $req->get('http://www.google.se');

        $this->assertInstanceOf('\Client\WebResponse', $response);

        $this->assertEquals(
            200,
            $response->httpCode
        );
    }
}
