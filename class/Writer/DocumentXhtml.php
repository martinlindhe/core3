<?php
namespace Writer;

/**
 * Helper class to generate XHTML documents
 *
 * TODO: allow for attach of a generic head block with META tags and keywords
 * TODO extend and render HTML5 directives
 */
class DocumentXhtml
{
    public function sendHttpHeaders()
    {
        $header = new \Writer\HttpHeader();
        $header->sendContentType('text/html; charset=utf-8');
    }

    public function render()
    {
        //throw new \Exception("TODO");
    }
}
