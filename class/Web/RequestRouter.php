<?php
namespace Web;

class RequestRouter
{
    protected $applicationDirectoryRoot;
    protected $applicationWebRoot;
    
    protected $routes;

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
        if ($this->applicationWebRoot == '/') {
            return $request;
        }

        $len = strlen($this->applicationWebRoot);

        if (substr($request, 0, $len) != $this->applicationWebRoot) {
            throw new \Exception('broken input');
        }

        return substr($request, $len);
    }

    /**
     * @param string $request Requested path
     * @return string rendered view
     */
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
        
        // call registered method
        if (isset($this->routes[$view])) {
            return $this->routes[$view]($param);
        }

        // SECURITY: all defined variables will be available to the view

        ob_start();
        include $this->getViewFilename($view);
        return ob_get_clean();
    }

    /**
     * @return bool if $viewName is valid (a-z, A-Z, 0-9 and -, and max 30 letters)
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
    
    /**
     * @param string $route
     */
    public function registerRoute($route, $callback)
    {
        $this->routes[$route] = $callback;
    }
}
