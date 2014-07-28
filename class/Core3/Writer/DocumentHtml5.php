<?php
namespace Core3\Writer;

class DocumentHtml5
{
    protected $includeJs = array();
    protected $jsOnload;
    protected $documentTitle;
    protected $documentBody;
    protected $embeddedCss;
    protected $embeddedJs;
    protected $baseHref;

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

    public function embedJs($code)
    {
        $this->embeddedJs .= $code;
    }

    public function attachToBody($code)
    {
        $this->documentBody .= $code;
    }

    public function setBaseHref($s)
    {
        $this->baseHref = $s;
    }

    public function render()
    {
        return
        '<!DOCTYPE html>'.
        '<html>'.
        '<head>'.
            $this->renderBaseHref().
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

    private function renderBaseHref()
    {
        if (!$this->baseHref) {
            return;
        }
        return '<base href="'.$this->baseHref.'"/>';
    }

    private function renderEmbeddedCss()
    {
        if (!$this->embeddedCss) {
            return;
        }
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
        $js = $this->embeddedJs;
        if ($this->jsOnload) {
            $js .= 'window.onload=function(){'.$this->jsOnload.'}';
        }

        if ($js) {
            return '<script type="text/javascript">'.$js.'</script>';
        }
    }
}
