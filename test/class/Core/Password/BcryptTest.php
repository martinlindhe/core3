<?php
namespace Core\Password;

/**
 * @group Core
 */
class BcryptTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * verify that repeated letter strings are disallowed
	 */
    function testIsAllowedRepeated()
    {
        $password = new Bcrypt();
        $this->assertEquals(false, $password->isAllowed('hhhhhh'));
        $this->assertEquals(false, $password->isAllowed('666666666666'));

        $this->assertEquals(false, $password->isAllowed('hahaha'));
        $this->assertEquals(false, $password->isAllowed('6969'));
        $this->assertEquals(false, $password->isAllowed('232323'));

        $this->assertEquals(false, $password->isAllowed('lollol'));
        $this->assertEquals(false, $password->isAllowed('sexsex'));
    }

    function testIsAllowedInBlocklist()
    {
        $password = new Bcrypt();

        // verify that a listed password is blocked, and that check is not case sensitive
        $this->assertEquals(false, $password->isAllowed('abc123'));
        $this->assertEquals(false, $password->isAllowed('ABC123'));
    }

    function testIsAllowed()
    {
        $password = new Bcrypt();

        // verify that passwords containing parts of blocked passwords are still allowed
        $this->assertEquals(true, $password->isAllowed('abc123hej'));
        $this->assertEquals(true, $password->isAllowed('hejabc123'));

        // verify that an unlisted password is allowed
        $this->assertEquals(true, $password->isAllowed('h4rdpassw0rd'));
    }

    function testGenerate()
    {
        $password = new Bcrypt();
        $hash = $password->hash('test');

        $this->assertEquals(60, strlen($hash));
    }

    function testVerify()
    {
        $password = new Bcrypt();
        $hashOne = $password->hash('test');
        $hashTwo = $password->hash('test');

        $this->assertNotEquals($hashOne, $hashTwo, 'verify that each hash are unique');

        $this->assertEquals(true, $password->verify('test', $hashOne));
        $this->assertEquals(true, $password->verify('test', $hashTwo));
    }

    function testNeedRehash()
    {
        // create a weak hash using cost 5
        $password = new Bcrypt(5);
        $hash = $password->hash('test');

        $this->assertEquals(true, $password->verify('test', $hash));

        $this->assertEquals(true, $password->needsRehash($hash, 10));
    }

    function testDontNeedRehash()
    {
        // create hash using default cost
        $password = new Bcrypt();
        $hash = $password->hash('test');

        $this->assertEquals(true, $password->verify('test', $hash));

        $this->assertEquals(false, $password->needsRehash($hash, $password->getCost()));
    }

    function testVerifyForbiddenFileExists()
    {
        $password = new Bcrypt();
        $filename = $password->getForbiddenPasswordsFilename();

        $this->assertEquals(true, file_exists($filename));
    }

}
