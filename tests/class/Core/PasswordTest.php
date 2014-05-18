<?php
/**
 * @group Core
 */

class Core_PasswordTest extends PHPUnit_Framework_TestCase
{
    /**
     * verify that repeated letter strings are disallowed
     */
    function testIsAllowedRepeated()
    {
        $this->assertEquals(false, Core_Password::isAllowed('hhhhhh') );
        $this->assertEquals(false, Core_Password::isAllowed('666666666666') );

        $this->assertEquals(false, Core_Password::isAllowed('hahaha') );
        $this->assertEquals(false, Core_Password::isAllowed('6969') );
        $this->assertEquals(false, Core_Password::isAllowed('232323') );

        $this->assertEquals(false, Core_Password::isAllowed('lollol') );
        $this->assertEquals(false, Core_Password::isAllowed('sexsex') );
    }

    function testIsAllowedInBlocklist()
    {
        // verify that a listed password is blocked, and that check is not case sensitive
        $this->assertEquals(false, Core_Password::isAllowed('abc123') );
        $this->assertEquals(false, Core_Password::isAllowed('ABC123') );
    }

    function testIsAllowed()
    {
        // verify that passwords containing parts of blocked passwords are still allowed
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

    function testNeedRehash()
    {
        // create a weak hash using cost 5
        $hash = Core_Password::hash('test', 5);

        $this->assertEquals( true, Core_Password::verify('test', $hash));

        $this->assertEquals( true, Core_Password::needsRehash($hash, 10) );
    }

    function testDontNeedRehash()
    {
        // create hash using default cost
        $hash = Core_Password::hash('test');

        $this->assertEquals( true, Core_Password::verify('test', $hash));

        $this->assertEquals( false, Core_Password::needsRehash($hash) );
    }

    /**
     * Looks in forbidden passwords file for useless rules, which are covered by the static validation checks
     */
    function testFindUselessForbiddenRules()
    {
        $filename = Core_Password::getForbiddenPasswordsFilename();

        $rows = explode("\n", trim(file_get_contents($filename)));

        $this->assertGreaterThanOrEqual( 488, count($rows) );

        foreach ($rows as $row) {
            $this->assertEquals( false, Core_Password::isRepeatingString($row), 'Asserting that string '.$row.' is not repeated' );
        }
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
