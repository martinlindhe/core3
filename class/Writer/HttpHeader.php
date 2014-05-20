<?php

class Writer_HttpHeader
{
    public function sendContentType($type)
    {
        header('Content-Type: '.$type);
    }

    public function sendAttachment($fileName)
    {
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
    }

    /**
     * Sends http headers that completely disables browser caching
     */
    public function sendNoCacheHeaders()
    {
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');

        header('Cache-Control: no-cache, must-revalidate, max-age=0'); // HTTP/1.1
        header("Pragma: no-cache");
    }

}
