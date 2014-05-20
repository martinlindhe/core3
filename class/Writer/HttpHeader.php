<?php

class Writer_HttpHeader
{
	public function sendContentType($type)
	{
		header('Content-Type: '.$type);
	}

	public function sendAttachment($fileName)
	{
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
	}

	public function sendInline($fileName)
	{
		header('Content-Disposition: inline; filename="'.$fileName.'"');
	}

	/**
	 * Sends http headers that completely disables browser caching
	 */
	public function sendNoCacheHeaders()
	{
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

		header('Cache-Control: no-cache, must-revalidate, max-age=0'); // HTTP/1.1
		header("Pragma: no-cache");
	}

	/**
	 * XSS prevention, specifies valid sources for inclusion of javascript files,
	 * see https://developer.mozilla.org/en-US/docs/Web/Security/CSP/Introducing_Content_Security_Policy
	 * WARNING: this will break all inline javascript
	 * SUPPORT: Firefox 23, Chrome 25 (Content-Security-Policy)
	 * SUPPORT SOON: IE10 (X-Content-Security-Policy), Safari (X-WebKit-CSP)
	 */
	public function sendContentSecurityPolicy($param)
	{
		header('Content-Security-Policy: '.$param);

		// TODO use Content-Security-Policy-Report-Only also
	}

	/**
	 * XSS prevention, forbids this document to be embedded in a frame from an external source,
	 * see https://developer.mozilla.org/en-US/docs/Web/HTTP/X-Frame-Options
	 * SUPPORT: Chrome 4.1, IE8, Firefox 3.6, Safari 4.0
	 *
	 * @param DENY, SAMEORIGIN, ALLOW-FROM uri
	 */
	public function sendFrameOptions($param)
	{
		header('X-Frame-Options: '.$param);
	}

}
