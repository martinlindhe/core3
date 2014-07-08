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
     * allows a-z, A-Z, 0-9, _ and -
     */
    public function isValidViewName($name)
    {
        if (strlen($name) <= 30 &&
            preg_match('/^[a-zA-Z0-9-_]+$/', $name) == 1
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return string full path of scss file for $viewName
     */
    public function getScssFileName($viewName)
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

    public function writeCache($outFile, $data)
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
     * @param $viewName
     * @return string compiled css
     */
    public function renderViewToCss($viewName)
    {
        $scssFile = $this->getScssFileName($viewName);
        if (!file_exists($scssFile)) {
            throw new \FileNotFoundException();
        }

        $scss = new \scssc();
        $scss->setImportPaths($this->importPath);
        $scss->setFormatter('scss_formatter_compressed');

        return $scss->compile('@import "'.basename($scssFile).'"');
    }
}
