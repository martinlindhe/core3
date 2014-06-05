<?php
namespace Client;

class WebRequest
{
	public static function Get($url, $headers = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if (is_array($headers)) {
			$curl_headers = array ();

			foreach ($headers as $key => $value) {
				$curl_headers[] = "$key: $value";
			}
			curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
		}

		$content = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return array ('content' => $content, 'http_code' => $http_code);
	}	
}