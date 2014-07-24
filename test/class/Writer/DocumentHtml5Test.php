<?php
namespace Writer;

/**
 * @group Writer
 */
class DocumentHtml5Test extends \PHPUnit_Framework_TestCase
{
    function testBasic()
    {
        $doc = new DocumentHtml5();

        $doc->embedCss(
            '#tag{'.
                'width:500px;'.
            '}'
        );

        $doc->attachJsOnload('alert("hello");');
        $doc->includeJs('http://url.com');
        $doc->attachToBody('<b>bold</b>');

        $this->assertEquals(
            '<!DOCTYPE html>'.
            '<html>'.
            '<head>'.
            '<title></title>'.
            '<style type="text/css">#tag{width:500px;}</style>'.
            '<script type="text/javascript" src="http://url.com"></script>'.
            '<script type="text/javascript">window.onload=function(){alert("hello");}</script>'.
            '</head>'.
            '<body><b>bold</b></body>'.
            '</html>',
            $doc->render()
        );
    }

    function testDoubleIncludeJs()
    {
        $doc = new DocumentHtml5();

        $doc->includeJs('http://url.com');
        $doc->includeJs('http://url.com');

        $this->assertEquals(
            '<!DOCTYPE html>'.
            '<html>'.
            '<head>'.
            '<title></title>'.
            '<script type="text/javascript" src="http://url.com"></script>'.
            '</head>'.
            '<body></body>'.
            '</html>',
            $doc->render()
        );
    }

    function testSetBaseHref()
    {
        $doc = new DocumentHtml5();

        $doc->setBaseHref('/app1/');

        $this->assertEquals(
            '<!DOCTYPE html>'.
            '<html>'.
            '<head>'.
            '<base href="/app1/"/>'.
            '<title></title>'.
            '</head>'.
            '<body></body>'.
            '</html>',
            $doc->render()
        );
    }

}
