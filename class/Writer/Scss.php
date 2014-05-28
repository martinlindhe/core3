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

	/**
	 * allows a-z,A-Z,0-9 and -
	 */
	public static function isValidScssFileName($name)
	{
		if (strlen($name) <= 30 &&
			preg_match('/^[a-zA-Z0-9-]+$/', $name) == 1
		) {
			return true;
		}

		return false;
	}

	public static function isModified($mtime, $etag)
	{
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) < $mtime) {
			return true;
		}

		if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] != $etag) {
			return true;
		}

		return false;
	}

	public static function sendValidationHeaders($mtime, $etag)
	{
		header('Last-Modified: '.gmdate('D, j M Y H:i:s', $mtime).' GMT');
		header('Etag: '.$etag);
	}

}
