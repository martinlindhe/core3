<?php

/**
 * @group Writer
 */
class ScssTest extends \PHPUnit_Framework_TestCase
{
    function testRenderCodeToCss()
    {
        // compile SASS to compressed CSS
        $scss = new \Writer\Scss();

        $code =
        '// comment
        .navigation {
            color: #777 + #777;
        }
        .footer {
            color: #222 * 2;
        }';

        $this->assertEquals(
            '.navigation{color:#eee;}.footer{color:#444;}',
            $scss->renderCodeToCss($code)
        );
    }

    function testRenderFileToCss()
    {
        // compile SASS (from file) to compressed CSS
        $scss = new \Writer\Scss();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss');
        file_put_contents($scssFile, $code);

        $scss->setImportPath(dirname($scssFile));

        $this->assertEquals(
            '.footer{color:#444;}',
            $scss->renderFileToCss($scssFile)
        );

        unlink($scssFile);
    }

    function testRenderFileToCssFile()
    {
        // compile SASS (from file) to compressed CSS (to file)
        $scss = new \Writer\Scss();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss');

        file_put_contents($scssFile, $code);

        $scss->setImportPath(dirname($scssFile));

        $this->assertEquals(
            '.footer{color:#444;}',
            $scss->renderFileToCss($scssFile)
        );

        unlink($scssFile);
    }

    function testIsValidViewName()
    {
        $scss = new \Writer\Scss();

        $this->assertEquals(true, $scss->isValidViewName('viewName'));
        $this->assertEquals(true, $scss->isValidViewName('viewName111'));
        $this->assertEquals(true, $scss->isValidViewName('view-name'));
        $this->assertEquals(true, $scss->isValidViewName('view_name'));

        $this->assertEquals(false, $scss->isValidViewName('view+name'));
        $this->assertEquals(false, $scss->isValidViewName('view%name'));
        $this->assertEquals(false, $scss->isValidViewName('view,name'));
        $this->assertEquals(false, $scss->isValidViewName('view"name'));
        $this->assertEquals(false, $scss->isValidViewName('view\'name'));
    }
}
