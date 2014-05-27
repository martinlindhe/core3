<?php
namespace Writer;

// STATUS: incomplete. not decided how to hook up this internally yet
// 		-- should use the scss_server class

require_once realpath(__DIR__.'/../../vendor/leafo/scssphp').'/scss.inc.php';

class Scss
{
	static $scss = null;

	private function __construct()
	{
	}

	public static function getInstance()
	{
		if (self::$scss == null) {
			self::$scss = new \scssc();
		}

		return self::$scss;
	}
}
