<?php
/**
 * @group Benchmark
 */

class Core_PasswordBenchmarkTest extends PHPUnit_Framework_TestCase
{

    /**
	 * Calculates an appropriate cost parameter for the current system
	 */
    function testFindAppropriateCost()
    {
        $timeTarget = 0.2;

        $cost = 9;
        do {
            $cost++;
            $start = microtime(true);

            $password = new Core_Password($cost);

            $password->hash("test");
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "\nAppropriate password_hash() cost found: " . $cost . "\n";
    }

}
