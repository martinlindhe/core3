<?php

/**
 * @return array with all header lines matching $headerKey 
 */
 function xdebug_find_headers($headerKey)
{
	// TODO: test this code
	$findKey = $headerKey.': ';
	$len = strlen($findKey);
	$res = array();

	foreach (xdebug_get_headers() as $hdr) {
		if (substr($hdr, 0, $len) == $findKey) {
			$res[] = substr($hdr, $len);
		}
	}

	return $res;
}
