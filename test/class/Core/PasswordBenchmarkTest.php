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

            $password = new Core_Password_Bcrypt($cost);

            $password->hash("test");
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "\nAppropriate password_hash() cost found: " . $cost . "\n";
    }

    /**
     * Looks in forbidden passwords file for useless rules,
     * which are covered by the validation checks
     */
    function testFindUselessForbiddenRules()
    {
        // TODO move this to a separate class & group it as Util (?)
        $password = new Core_Password_Bcrypt();

        $filename = $password->getForbiddenPasswordsFilename();

        $rows = explode("\n", trim(file_get_contents($filename)));

        $this->assertGreaterThanOrEqual(488, count($rows));

        foreach ($rows as $row) {
            $this->assertEquals(
                false,
                $password->isRepeatingString($row),
                'Asserting that string '.$row.' is not repeated'
            );
        }
    }
}
