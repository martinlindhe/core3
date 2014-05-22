<?php

class Web_RequestRouter
{
    protected $applicationRoot;

    public function setApplicationRoot($path)
    {
        if (!is_dir($path)) {
            throw new Exception('invalid path');
        }
        $this->applicationRoot = realpath($path);
    }

    public function route($request)
    {
        $parts = explode('/', $request);

        if ($parts[0] != '') {
            throw new Exception("broken input!!");
        }

        $viewName = $parts[1];

        if (strlen($viewName) > 20) {
            throw new Exception('too long view name');
        }

        if (!$viewName) {
            throw new Exception ('no view name');
        }

        if (count($parts) > 2) {
            throw new Exception('TODO params');
        }


        // TODO validera att viewName bara innehåller a-z i små bokstäver


        $fileName = $this->applicationRoot.'/view/'.$viewName.'.html';
        $data = file_get_contents($fileName);
        echo $data;
    }
}
