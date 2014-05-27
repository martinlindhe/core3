<?php

/**
 * @group Writer
 */
class ScssTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        // compile SASS to compressed CSS
        $scss = \Writer\Scss::getInstance();

        $code =
        '
        // comment
        .navigation {
            color: #777 + #777;
        }
        .footer {
            color: #222 * 2;
        }';

        $scss->setFormatter('scss_formatter_compressed');

        $this->assertEquals(
            '.navigation{color:#eee;}.footer{color:#444;}',
            $scss->compile($code)
        );
    }
}
