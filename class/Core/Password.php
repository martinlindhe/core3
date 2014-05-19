<?php

// NOTE password_hash() requires php 5.5 or https://github.com/ircmaxell/password_compat.git

class Core_Password
{
	/**
	 * @return 60-byte string with password hash
	 */
	public static function hash($password, $cost = 10)
	{
		$options = array(
		'cost' => $cost,
		);

		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	/**
	 * Used to determine if password hash needs to be re-generated when cost has changed
	 * @return bool
	 */
	public static function needsRehash($hash, $cost = 10)
	{
		$options = array(
		'cost' => $cost,
		);

		return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
	}

	/**
	 * Verifies if entered password equals stored password hash
	 * @return bool
	 */
	public static function verify($password, $hash)
	{
		return password_verify($password, $hash);
	}

	public static function isRepeatingString($s)
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

	public static function getForbiddenPasswordsFilename()
	{
		return dirname(__FILE__).'/../../data/Password.forbidden.txt';
	}

	/**
	 * Checks against password blacklist wether input
	 * is allowed for use as
	 */
	public static function isAllowed($password)
	{
		if (self::isRepeatingString($password)) {
			return false;
		}

		$chk_file = self::getForbiddenPasswordsFilename();

		$data = file_get_contents($chk_file);

		return strpos($data, (strtolower($password)) ) === false;
	}

}
