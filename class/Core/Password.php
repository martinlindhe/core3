<?php

// NOTE: password_hash() requires php 5.5, password_compat is shipped in lib (requires php 5.3.7)

class Core_Password
{
	protected $cost;

	public function __construct($cost = 10)
	{
		$this->cost = $cost;
	}

	public function getCost()
	{
		return $this->cost;
	}

	/**
	 * @return 60-byte string with password hash
	 */
	public function hash($password)
	{
		$options = array(
		'cost' => $this->cost,
		);

		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	/**
	 * Used to determine if password hash needs to be re-generated when cost has changed
	 * @param $hash current hash
	 * @param $new_cost new cost
	 * @return bool
	 */
	public function needsRehash($hash, $new_cost)
	{
		$options = array(
		'cost' => $new_cost,
		);

		return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
	}

	/**
	 * Verifies if entered password equals stored password hash
	 * @return bool
	 */
	public function verify($password, $hash)
	{
		return password_verify($password, $hash);
	}

	public function isRepeatingString($s)
	{
		$len = strlen($s);

		// disallow repeated letters
		if (str_repeat(substr($s, 0, 1), $len) == $s) {
			return true;
		}

		// disallow repeated letter pairs
		if (str_repeat(substr($s, 0, 2), $len/2) == $s) {
			return true;
		}

		// disallow repeated letter triplets
		if (str_repeat(substr($s, 0, 3), $len/3) == $s) {
			return true;
		}

		return false;
	}

	public function getForbiddenPasswordsFilename()
	{
		return dirname(__FILE__).'/../../data/Password.forbidden.txt';
	}

	/**
	 * Checks against password blacklist wether input
	 * is allowed for use as
	 */
	public function isAllowed($password)
	{
		if ($this->isRepeatingString($password)) {
			return false;
		}

		$chk_file = $this->getForbiddenPasswordsFilename();

		$data = file_get_contents($chk_file);

		return strpos($data, strtolower($password)) === false;
	}

}
