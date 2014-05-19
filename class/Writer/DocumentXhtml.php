<?php
/**
 * Helper class to generate XHTML documents
 *
 * TODO: allow for attach of a generic head block with META tags and keywords
 * TODO extend and render HTML5 directives
 */

class Writer_DocumentXhtml
{
	public function sendHttpHeaders()
	{
		header('Content-Type: text/html; charset=utf-8');

		/*
		// IE8, Fiefox 3.6: "Clickjacking Defense" (XSS prevention), Forbids this document to be embedded in a frame from
		// an external source, see https://developer.mozilla.org/en/the_x-frame-options_response_header
		// and http://blogs.msdn.com/b/ie/archive/2009/01/27/ie8-security-part-vii-clickjacking-defenses.aspx
		header('X-Frame-Options: '.($this->allow_internal_framing ? 'SAMEORIGIN' : 'DENY') );

		// IE8: "XSS Filter"
		// see http://blogs.msdn.com/b/ie/archive/2008/07/01/ie8-security-part-iv-the-xss-filter.aspx
		header('X-XSS-Protection: 1; mode=block');

		// Firefox 4: XSS prevention, specifies valid sources for inclusion of javascript files,
		// see https://developer.mozilla.org/en/Introducing_Content_Security_Policy
		// DISABLED FOR NOW! we need to eliminate inline javascript due to base restriction "No inline scripts will execute":
		// https://wiki.mozilla.org/Security/CSP/Specification#Base_Restrictions

		header("X-Content-Security-Policy: allow 'self' http://connect.facebook.net");
		*/
	}

	public function add(ObjectXhtml $o)
	{
		throw new Exception ("TODO");
	}

	public function render()
	{
		throw new Exception ("TODO");
	}
}
