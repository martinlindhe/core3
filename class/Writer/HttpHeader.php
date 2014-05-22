<?php
namespace Writer;

class HttpHeader
{
    public function sendContentType($type)
    {
        header('Content-Type: '.$type);
    }

    /**
	 * Sends http headers that causes the document to popup a "save as" dialog
	 * @param $fileName name of document
	 */
    public function sendAttachment($fileName)
    {
        header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
    }

    /**
	 * Sends http headers that causes the document to be inlined (default behavior),
	 * but with a defined name should the user choose to "save as"
	 * @param $fileName name of document
	 */
    public function sendInline($fileName)
    {
        header('Content-Disposition: inline; filename="'.basename($fileName).'"');
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
	 * Content Security Policy (CSP) allows one to specify valid sources
	 * for inclusion of resources such as javascript and images,
	 * see https://developer.mozilla.org/en-US/docs/Web/Security/CSP/Introducing_Content_Security_Policy
	 * SUPPORT: Firefox 23, Chrome 25 (Content-Security-Policy)
	 * SUPPORT SOON: IE10 (X-Content-Security-Policy), Safari (X-WebKit-CSP)
	 *
	 * @param $param CSP configuration string
	 */
    public function sendContentSecurityPolicy($param)
    {
        header('Content-Security-Policy: '.$param);
    }

    /**
	 * For debugging Content Security Policy (CSP) issues
	 *
	 * @param $param CSP configuration string
	 */
    public function sendContentSecurityPolicyReportOnly($param)
    {
        header('Content-Security-Policy-Report-Only: '.$param);
    }

    /**
	 * X-Frame-Options forbids this document to be embedded in a frame (XSS protection)
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
