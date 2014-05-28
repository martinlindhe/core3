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

	public function isClientCacheDirty($etag)
	{
		if (!isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
			return true;
		}

		if ($_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
			return false;
		}

		return true;
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

		if (!file_exists($cachedFile)) {
			header('X-SCSS-1: rendering');
			$data = $this->renderToFile($scssFile, $cachedFile);
		}

		$cachedMtime = filemtime($cachedFile);

		$etag = md5($cachedFile.$cachedMtime);
		$data = '';

		if ($this->isClientCacheDirty($etag)) {
			// serve cached copy if browser didnt have it cached
			header('X-SCSS: sending');
			$httpCode = 200;
			$data = file_get_contents($cachedFile);
		} else {
			header('X-SCSS: cached-in-client');
			$httpCode = 302;
		}

		header('Content-Type: text/css');
		header('ETag: '.$etag);
		http_response_code(302);

		echo $data;
	}

	/**
	 * @param $scssFile scss file to render
	 */
	public function render($scssFile)
	{
		// render document
		$scss = new \scssc();
		$scss->setImportPaths($this->importPath);
		$scss->setFormatter('scss_formatter_compressed');

		return $scss->compile('@import "'.basename($scssFile).'"');
	}

	public function renderToFile($scssFile, $cachedFile)
	{
		file_put_contents($cachedFile, $this->render($scssFile));
	}
}
