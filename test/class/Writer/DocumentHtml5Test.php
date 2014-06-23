<?php
namespace Writer;

/**
 * @group Writer
 */
class DocumentHtml5Test extends \PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
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
}
