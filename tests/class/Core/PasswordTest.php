<?php
/**
 * @group Core
 */

class Core_PasswordTest extends PHPUnit_Framework_TestCase
{
    function testIsAllowed()
    {
        // verify that a listed password is blocked, and that check is not case sensitive
        $this->assertEquals(false, Core_Password::isAllowed('abc123') );
        $this->assertEquals(false, Core_Password::isAllowed('ABC123') );

        // should not block passwords containing parts of blocked passwords
        $this->assertEquals(true, Core_Password::isAllowed('abc123hej') );
        $this->assertEquals(true, Core_Password::isAllowed('hejabc123') );

        // verify that an unlisted password is allowed
        $this->assertEquals(true,  Core_Password::isAllowed('h4rdpassw0rd') );
    }

    function testGenerate()
    {
        $hash = Core_Password::hash('test');

        $this->assertEquals(60, strlen($hash));
    }

    function testVerify()
    {
        $hash1 = Core_Password::hash('test');
        $hash2 = Core_Password::hash('test');

        $this->assertNotEquals($hash1, $hash2, 'verify that each hash are unique');

        $this->assertEquals( true, Core_Password::verify('test', $hash1));
        $this->assertEquals( true, Core_Password::verify('test', $hash2));
    }

    /**
     * Calculates an appropriate cost parameter for the current system
     */
     /*
    function testFindAppropriateCost()
    {
        // TODO how to exclude this one except if we run specifically "benchmark" tests ?'
        $this->markTestSkipped('skipped test);

        $timeTarget = 0.2;

        $cost = 9;
        do {
            $cost++;
            $start = microtime(true);
            Core_Password::hash("test", $cost);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "Appropriate Cost Found: " . $cost . "\n";
    }
    */
}
