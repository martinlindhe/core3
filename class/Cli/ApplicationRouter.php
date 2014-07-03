<?php
namespace Cli;

/**
 * Routes cli applications to the user
 * Invoke with the core3/cli.php util
 */
class ApplicationRouter
{
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

    public function printAvailableRoutes($scriptName)
    {
        // core3 cli views
        $files = glob(__DIR__.'/../../cli/*.{php}', GLOB_BRACE);
        foreach ($files as $file) {
            $viewName = substr(basename($file), 0, -4);
            echo '  '.$scriptName.' '.str_pad($viewName, 20).' [core]'."\n";
        }

        // app cli views
        $files = glob(getcwd().'/cli/*.{php}', GLOB_BRACE);
        foreach ($files as $file) {
            $viewName = substr(basename($file), 0, -4);
            echo '  '.$scriptName.' '.str_pad($viewName, 20).' [app]'."\n";
        }

        echo "\n";
    }

    /**
     * Route cli view
     */
    public function route($viewName)
    {
        if (!$this->isValidViewName($viewName)) {
            throw new \Exception("Invalid name");
        }

        // look for app cli view
        $cliViewFile = getcwd().'/cli/'.$viewName.'.php';

        if (!file_exists($cliViewFile)) {
            // look for core cli view
            $cliViewFile = __DIR__.'/../../cli/'.$viewName.'.php';
            if (!file_exists($cliViewFile)) {
                throw new \Exception("Invalid command");
            }
        }

        include $cliViewFile;
    }
}
