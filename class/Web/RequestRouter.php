<?php
namespace Web;

class RequestRouter
{
    protected $applicationDirectoryRoot;
    protected $applicationWebRoot;

    public function setApplicationDirectoryRoot($path)
    {
        if (!is_dir($path)) {
            throw new \DirectoryNotFoundRexception();
        }

        $this->applicationDirectoryRoot = realpath($path);
    }

    public function setApplicationWebRoot($path)
    {
        $this->applicationWebRoot = $path;
    }

    public function route($request)
    {
        if ($this->applicationWebRoot) {
            $len = strlen($this->applicationWebRoot);
            if (substr($request, 0, $len) != $this->applicationWebRoot) {
                throw new \Exception('broken input one !');
            }
            $request = substr($request, $len);
        }

        $parts = explode('/', $request);

        if (count($parts) < 2 || $parts[0] != '') {
            throw new \Exception("broken input two !");
        }

        $viewName = $parts[1];

        if (!$viewName) {
            $viewName = 'index';
        }

        if (!$this->isValidViewName($viewName)) {
            $viewName = '404notfound';
        }

        if (count($parts) > 2) {
            var_dump($parts);
            throw new \Exception('TODO params, requested '.$request);
        }

        \Writer\DocumentXhtml::sendHttpHeaders();

        $fileName = $this->getViewFilename($viewName);

        include $fileName;
    }

    /**
     * @return true if $viewName is valid (lowercase a-z and max 20 letters)
     */
    public function isValidViewName($viewName)
    {
        if (strlen($viewName) <= 20 &&
            preg_match('/^[a-z]+$/', $viewName) == 1
        ) {
            return true;
        }
        return false;
    }

    public function getViewFilename($viewName)
    {
        // application template
        $fileName = $this->applicationDirectoryRoot.'/view/'.$viewName.'.php';
        if (file_exists($fileName)) {
            return $fileName;
        }

        // system template
        $fileName = realpath(__DIR__.'/../..').'/view/'.$viewName.'.php';
        if (!file_exists($fileName)) {
             return $this->getViewFilename('404notfound');
        }

        return $fileName;
    }
}
