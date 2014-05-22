<?php
// TODO tests

class Web_RequestRouter
{
    protected $applicationDirectoryRoot;
    protected $applicationWebRoot;

    public function setApplicationDirectoryRoot($path)
    {
        if (!is_dir($path)) {
            throw new Exception('invalid path');
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
                throw new Exception('broken input one !');
            }
            $request = substr($request, $len);
        }

        $parts = explode('/', $request);

        if (count($parts) < 2 || $parts[0] != '') {
            throw new Exception("broken input two !");
        }

        $viewName = $parts[1];

        if (!$viewName) {
            $viewName = 'index';
        }

        if (strlen($viewName) > 20) {
            $viewName = '404notfound';
        }

        if (count($parts) > 2) {
            var_dump($parts);
            throw new Exception('TODO params');
        }

        if (!$this->isValidViewName($viewName)) {
            $viewName = '404notfound';
            throw new Exception("MOO");
        }

        $fileName = $this->getViewFilename($viewName);
        if (!$fileName) {
            $fileName = $this->getViewFilename('404notfound');
        }

        $data = file_get_contents($fileName);
        echo $data;
    }

    /**
     * @return true if $viewName is valid (only lowercase a-z)
     */
    public function isValidViewName($viewName)
    {
        if (preg_match('/^[a-z]+$/', $viewName) == 1) {
            return true;
        }
        return false;
    }

    public function getViewFilename($viewName)
    {
        // application template
        $fileName = $this->applicationDirectoryRoot.'/view/'.$viewName.'.html';
        if (file_exists($fileName)) {
            return $fileName;
        }

        // system template
        $fileName = realpath(__DIR__.'/../..').'/view/'.$viewName.'.html';
        if (!file_exists($fileName)) {
            return false;
        }

        return $fileName;
    }
}
