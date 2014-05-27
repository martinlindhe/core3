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

    public function stripApplicationPrefix($request)
    {
        $len = strlen($this->applicationWebRoot);

        if (substr($request, 0, $len) != $this->applicationWebRoot) {
            throw new \Exception('broken input one !');
        }

        return substr($request, $len);
    }

    public function route($request)
    {
        if ($this->applicationWebRoot) {
            $request = $this->stripApplicationPrefix($request);
        }

        $parts = explode('/', $request);

        $view = $parts[1];

        if (!$view) {
            $view = 'index';
        }

        if (!$this->isValidViewName($view)) {
            $view = '404notfound';
        }

        $param = array();
        if (count($parts) > 2) {
            $param = array_slice($parts, 2);
        }
        unset($parts);

        \Writer\DocumentXhtml::sendHttpHeaders();

        // SECURITY NOTE: all defined variables will be available to the view
        // $request  string   web request
        // $view     string   name of the view
        // $param    array    the parameters passed to this view

        include $this->getViewFilename($view);
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
