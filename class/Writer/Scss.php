<?php
namespace Writer;

require_once realpath(__DIR__.'/../../vendor/leafo/scssphp').'/scss.inc.php';

class Scss
{
	protected $importPath;

	public function setImportPath($path)
	{
		$this->importPath = $path;
	}

	/**
	 * allows a-z,A-Z,0-9 and -
	 */
	public function isValidViewName($name)
	{
		if (strlen($name) <= 30 &&
			preg_match('/^[a-zA-Z0-9-]+$/', $name) == 1
		) {
			return true;
		}

		return false;
	}

	public function isModified($mtime, $etag)
	{
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) < $mtime) {
			return true;
		}

		if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] != $etag) {
			return true;
		}

		return false;
	}

	public function sendValidationHeaders($mtime, $etag)
	{
		header('Last-Modified: '.gmdate('D, j M Y H:i:s', $mtime).' GMT');
		header('Etag: '.$etag);
	}

	/**
	 * WARNING: outputs result to stdout and sets http headers
	 */
	public function handle($viewName)
	{
		if (!$this->isValidViewName($viewName)) {
			http_response_code(400); // Bad Request
			header('Content-Type: application/json');
			echo json_encode(array('code'=>400, 'message'=>'Invalid scss name'));
			return;
		}

		$scssFile = $this->importPath.'/'.$viewName.'.scss';
		$cachedFile = $this->importPath.'/'.$viewName.'.compiled.css';

		if (!file_exists($scssFile)) {
			// TODO refactor API error message
			http_response_code(400); // Bad Request
			header('Content-Type: application/json');
			echo json_encode(array('code'=>400, 'message'=>'No such scss file: '.$scssFile));
			return;
		}

		$scssMtime = filemtime($scssFile);

		$cachedMtime = 0;
		if (file_exists($cachedFile)) {
			$cachedMtime = filemtime($cachedFile);
		}

		$etag = md5($scssFile.$cachedMtime);

		header('Content-Type: text/css');

		if ($cachedMtime > $scssMtime) {

			$this->sendValidationHeaders($cachedMtime, $etag);

			if ($this->isModified($cachedMtime, $etag)) {
				// serve cached copy if browser didnt have it cached
				readfile($cachedFile);
			} else {
				http_response_code(304);   // Not Modified
			}
			return;

		}

		if (!$cachedMtime) {
			$cachedMtime = time();
		}

		$this->sendValidationHeaders($cachedMtime, $etag);

		$scss = new \scssc();
		$scss->setImportPaths($this->importPath);
		$scss->setFormatter('scss_formatter_compressed');

		$data = $scss->compile('@import "'.basename($scssFile).'"');
		echo $data;
		file_put_contents($cachedFile, $data);
	}
}
