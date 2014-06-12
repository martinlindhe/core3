<?php

/**
 * @group Api
 */
class ResponseErrorTest extends \PHPUnit_Framework_TestCase
{
    function test400()
    {
        $this->assertEquals(
            '{"code":400,"message":"General error"}',
            \Api\ResponseError::render(400)
        );
    }

    function testCustom()
    {
        $this->assertEquals(
            '{"code":999,"message":"whats up"}',
            \Api\ResponseError::render(999, 'whats up')
        );
    }
    
    function testExceptionToJson()
    {
        $json =
            '{'.
            '"code":420,'.
            '"status":"exception",'.
            '"exception":"InvalidArgumentException",'.
            '"message":"",'.
            '"file":"'.__FILE__.'",'.
            '"line":'.(__LINE__+5).
            '}';

        $this->assertEquals(
            $json,
            \Api\ResponseError::exceptionToJson(new \InvalidArgumentException())
        );
    }
}
