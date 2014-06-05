<?php
namespace Client;

class WebRequest
{
	private $ch; ///< cURL handle

	public function __construct()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);		
	}
	
	public function __destruct()
	{
		curl_close($this->ch);
	}

	/**
	 * Performs a simple HTTP GET request
	 * @param string $url
	 * @param array $headers
	 * @return \Client\WebResponse
	 */
	public function Get($url, array $headers = array())
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);

		$this->setHeaders($headers);
		
		$res = new WebResponse();
		$res->content = curl_exec($this->ch);
		$res->httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

		return $res;
	}
	
	private function setHeaders(array $headers)
	{
		$curl_headers = array();

		foreach ($headers as $key => $value) {
			$curl_headers[] = "$key: $value";
		}

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $curl_headers);
	}
}