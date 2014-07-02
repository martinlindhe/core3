<?php
namespace Writer;

/**
 * Uses scssphp from http://leafo.net/scssphp/
 */
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
     * @return string full path of scss file for $viewName
     */
    public function getScssFile($viewName)
    {
        if (!is_dir($this->importPath)) {
            throw new \DirectoryNotFoundRexception();
        }

        if (!$this->isValidViewName($viewName)) {
            throw new \Exception('Invalid scss name');
        }
        return $this->importPath.'/'.$viewName.'.scss';
    }

    /**
     * @return string full path of cached file for compiled $viewName
     */
    public function getCachedFileName($viewName)
    {
        if (!$this->isValidViewName($viewName)) {
            throw new \Exception('Invalid scss name');
        }
        return $this->importPath.'/compiled/'.$viewName.'.compiled.css';
    }

    public function getCachedFileMtime($viewName)
    {
        $cachedFile = $this->getCachedFileName($viewName);

        if (!file_exists($cachedFile)) {
            throw new \FileNotFoundException('Scss not found');
        }

        return filemtime($cachedFile);
    }

    /**
     * Uses or creates cached version as needed
     * @return string rendered view into css
     */
    public function renderView($viewName, $readCache = true)
    {
        $scssFile = $this->getScssFile($viewName);
        if (!file_exists($scssFile)) {
            throw new \FileNotFoundException();
        }

        $cachedFile = $this->getCachedFileName($viewName);
        if ($readCache) {
            if (file_exists($cachedFile)) {
                return file_get_contents($cachedFile);
            }
        }

        $data = $this->renderFileToCss($scssFile);

        $this->writeCache($cachedFile, $data);

        return $data;
    }

    private function writeCache($outFile, $data)
    {
        $dstDir = dirname($outFile);
        if (!is_dir($dstDir)) {
            throw new \DirectoryNotFoundRexception($dstDir);
        }
        if (!is_writable($dstDir)) {
           throw new \WritePermissionDeniedException($dstDir);
        }

        file_put_contents($outFile, $data);
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
}
