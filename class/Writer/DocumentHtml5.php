<?php
namespace Writer;

class DocumentHtml5
{
    protected $includeJs = array();
    protected $jsOnload;
    protected $documentTitle;
    protected $documentBody;
    protected $embeddedCss;

    public function includeJs($url)
    {
        if (in_array($url, $this->includeJs)) {
            return;
        }

        $this->includeJs[] = $url;
    }

    public function attachJsOnload($code)
    {
        $this->jsOnload .= $code;
    }

    public function embedCss($code)
    {
        $this->embeddedCss .= $code;
    }

    public function attachToBody($code)
    {
        $this->documentBody .= $code;
    }

    public function render()
    {
        return
        '<!DOCTYPE html>'.
        '<html>'.
        '<head>'.
            $this->renderDocumentTitle().
            $this->renderEmbeddedCss().
            $this->renderIncludeJs().
            $this->renderEmbeddedJs().
        '</head>'.
        '<body>'.
            $this->documentBody.
        '</body>'.
        '</html>';
    }

    private function renderEmbeddedCss()
    {
        return '<style type="text/css">'.$this->embeddedCss.'</style>';
    }

    /**
     * html5 requires the title tag
     */
    private function renderDocumentTitle()
    {
        return '<title>'.$this->documentTitle.'</title>';
    }

    private function renderIncludeJs()
    {
        $res = '';
        foreach ($this->includeJs as $uri) {
            $res .= '<script type="text/javascript" src="'.$uri.'"></script>';
        }
        return $res;
    }

    private function renderEmbeddedJs()
    {
        $js = '';
        if ($this->jsOnload) {
            $js .= 'window.onload=function(){'.$this->jsOnload.'}';
        }

        if ($js) {
            return '<script type="text/javascript">'.$js.'</script>';
        }
    }
}