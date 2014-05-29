<?php

/**
 * @group Writer
 */
class ScssTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        // compile SASS to compressed CSS
        $scss = new \Writer\Scss();

        $code =
        '
        // comment
        .navigation {
            color: #777 + #777;
        }
        .footer {
            color: #222 * 2;
        }';

        $this->assertEquals(
            '.navigation{color:#eee;}.footer{color:#444;}',
            $scss->render($code)
        );
    }
}
