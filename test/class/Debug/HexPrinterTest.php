<?php

/**
 * @group Debug
 */
class HexPrinterTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $x = new \Debug\HexPrinter();

        $this->assertEquals(
            "68 65 6c 6c 6f                                   hello\n",
            $x->render('hello')
        );
    }
}
