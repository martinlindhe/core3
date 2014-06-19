<?php
namespace Writer;

class Scss
{
    protected $importPath;

    public function setImportPath($path)
    {
        if (!is_dir($path)) {
            throw new \DirectoryNotFoundRexception();
        }

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

    /**
     * Returns true if the client has same version
     * of the document corresponding to $etag
     *
     */
    public function isClientCacheDirty($etag)
    {
        if (!isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            return true;
        }

        if ($_SERVER['HTTP_IF_NONE_MATCH'] != $etag) {
            return true;
        }

        return false;
    }

    /**
     * @param type $viewName base name of view to handle (without extension)
     * @return type
     * @throws \FileNotFoundException
     * @throws \CachedApiException
     */
    public function handle($viewName)
    {
        $scssFile = $this->getScssFile($viewName);
        if (!file_exists($scssFile)) {
            throw new \FileNotFoundException('Scss not found');
        }

        $cachedFile = $this->getCachedFile($viewName);
        if (file_exists($cachedFile)) {
            $data = file_get_contents($cachedFile);
        } else {
            $data = $this->renderFileToCssFile($scssFile, $cachedFile);
        }

        $etag = $this->getETag($viewName);

        // TODO dont set headers in here
        header('ETag: '.$etag);

        $timestamp = filemtime($cachedFile);
        header('Last-Modified: '.gmdate('D, d M Y H:i:s ', $timestamp).'GMT');

        if (!$this->isClientCacheDirty($etag)) {
            throw new \CachedInClientException();
        }

        return $data;
    }

    /**
     * @return string full path of scss file for $viewName
     */
    public function getScssFile($viewName)
    {
        if (!$this->isValidViewName($viewName)) {
            throw new \Exception('Invalid scss name');
        }
        return $this->importPath.'/'.$viewName.'.scss';
    }

    /**
     * @return string full path of cached file for compiled $viewName
     */
    public function getCachedFile($viewName)
    {
        if (!$this->isValidViewName($viewName)) {
            throw new \Exception('Invalid scss name');
        }
        return $this->importPath.'/compiled/'.$viewName.'.compiled.css';
    }

    public function getETag($viewName)
    {
        $cachedFile = $this->getCachedFile($viewName);

        if (!file_exists($cachedFile)) {
            throw new \FileNotFoundException('Scss not found');
        }

        $cachedMtime = filemtime($cachedFile);
        return '"'.md5($cachedFile.$cachedMtime).'"';
    }

    /**
     * Render a scss file to css
     * @param $scssFile scss file to render
     * @return string compiled css
     */
    public function renderFileToCss($scssFile)
    {
        $scss = new \scssc();
        $scss->setImportPaths($this->importPath);
        $scss->setFormatter('scss_formatter_compressed');

        return $scss->compile('@import "'.basename($scssFile).'"');
    }

    /**
     * Render a scss code block to css
     * @return string compiled css
     */
    public function renderCodeToCss($scssCode)
    {
        $scss = new \scssc();
        $scss->setFormatter('scss_formatter_compressed');

        return $scss->compile($scssCode);
    }

    /**
     * Render a scss file to css and writes to disk
     * @return string compiled css
     */
    public function renderFileToCssFile($scssFile, $outFile)
    {
        $dstDir = dirname($outFile);
        if (!is_dir($dstDir)) {
            throw new \DirectoryNotFoundRexception($dstDir);
        }
        if (!is_writable($dstDir)) {
           throw new \WritePermissionDeniedException($dstDir);
        }

        $data = $this->renderFileToCss($scssFile);

        file_put_contents($outFile, $data);

        return $data;
    }
}
