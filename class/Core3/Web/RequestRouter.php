<?php
namespace Core3\Web;

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
        if (substr($path, -1, 1) != '/') {
            $path .= '/';
        }
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

        return substr($request, $len - 1);
    }

    /**
     * @param string $request Requested path
     * @return string rendered view
     */
    public function route($request, $requestMethod)
    {
        $request = $this->stripApplicationPrefix($request);

        $parts = explode('/', $request);

        $view = '';
        if (count($parts) > 1) {
            $view = $parts[1];
        }

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

        // make sure array keys are defined in view
        for ($i = 0; $i < 3; $i++) {
            if (!isset($param[$i])) {
                $param[$i] = '';
            }
        }

        // call registered method
        if (isset($this->routes[$view])) {
            return $this->routes[$view]($requestMethod, $param);
        }

        // SECURITY: all defined variables from current
        //           scope is available in the view
        $webRoot = $this->applicationWebRoot;

        ob_start();
        include $this->getViewFilename($view);
        return ob_get_clean();
    }

    /**
     * Only send http response code if not in CLI mode
     */
    public function setHttpResponseCode($n)
    {
        if (PHP_SAPI == 'cli') {
            return;
        }
        http_response_code($n);
    }

    /**
     * @return bool if $viewName is valid (a-z, A-Z, 0-9, _ and -, and max 30 letters)
     */
    public function isValidViewName($name)
    {
        if (strlen($name) <= 30 &&
            preg_match('/^[a-zA-Z0-9_-]+$/', $name) == 1
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
        $fileName = realpath(__DIR__.'/../../..').'/view/'.$viewName.'.php';
        if (!file_exists($fileName)) {
             return $this->getViewFilename('404notfound');
        }

        return $fileName;
    }

    /**
     * Registers routing from a view name to a callback function
     * @param string $viewName
     */
    public function registerRoute($viewName, $callback)
    {
        $this->routes[$viewName] = $callback;
    }
}
