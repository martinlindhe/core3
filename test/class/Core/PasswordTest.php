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
		$password = new Core_Password();
		$this->assertEquals(false, $password->isAllowed('hhhhhh') );
		$this->assertEquals(false, $password->isAllowed('666666666666') );

		$this->assertEquals(false, $password->isAllowed('hahaha') );
		$this->assertEquals(false, $password->isAllowed('6969') );
		$this->assertEquals(false, $password->isAllowed('232323') );

		$this->assertEquals(false, $password->isAllowed('lollol') );
		$this->assertEquals(false, $password->isAllowed('sexsex') );
	}

	function testIsAllowedInBlocklist()
	{
		$password = new Core_Password();

		// verify that a listed password is blocked, and that check is not case sensitive
		$this->assertEquals(false, $password->isAllowed('abc123') );
		$this->assertEquals(false, $password->isAllowed('ABC123') );
	}

	function testIsAllowed()
	{
		$password = new Core_Password();

		// verify that passwords containing parts of blocked passwords are still allowed
		$this->assertEquals(true, $password->isAllowed('abc123hej') );
		$this->assertEquals(true, $password->isAllowed('hejabc123') );

		// verify that an unlisted password is allowed
		$this->assertEquals(true, $password->isAllowed('h4rdpassw0rd') );
	}

	function testGenerate()
	{
		$password = new Core_Password();
		$hash = $password->hash('test');

		$this->assertEquals(60, strlen($hash));
	}

	function testVerify()
	{
		$password = new Core_Password();
		$hash1 = $password->hash('test');
		$hash2 = $password->hash('test');

		$this->assertNotEquals($hash1, $hash2, 'verify that each hash are unique');

		$this->assertEquals( true, $password->verify('test', $hash1));
		$this->assertEquals( true, $password->verify('test', $hash2));
	}

	function testNeedRehash()
	{
		// create a weak hash using cost 5
		$password = new Core_Password(5);
		$hash = $password->hash('test');

		$this->assertEquals( true, $password->verify('test', $hash));

		$this->assertEquals( true, $password->needsRehash($hash, 10) );
	}

	function testDontNeedRehash()
	{
		// create hash using default cost
		$password = new Core_Password();
		$hash = $password->hash('test');

		$this->assertEquals( true, $password->verify('test', $hash));

		$this->assertEquals( false, $password->needsRehash($hash, $password->getCost()) );
	}

	function testVerifyForbiddenFileExists()
	{
		$password = new Core_Password();
		$filename = $password->getForbiddenPasswordsFilename();

		$this->assertEquals( true, file_exists($filename) );
	}

	/**
	 * Looks in forbidden passwords file for useless rules, which are covered by the validation checks
	 */
	function testFindUselessForbiddenRules()
	{
		// TODO move this to a separate class & group it as Util (?=)
		$password = new Core_Password();

		$filename = $password->getForbiddenPasswordsFilename();

		$rows = explode("\n", trim(file_get_contents($filename)));

		$this->assertGreaterThanOrEqual( 488, count($rows) );

		foreach ($rows as $row) {
			$this->assertEquals( false, $password->isRepeatingString($row), 'Asserting that string '.$row.' is not repeated' );
		}
	}

}
