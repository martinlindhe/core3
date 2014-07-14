<?php

/**
 * @group Writer
 */
class ScssTest extends \PHPUnit_Framework_TestCase
{
    private function getScssInstance()
    {
        $scss = new \Writer\Scss();
        $scss->setFormatterModeCompressed();
        return $scss;
    }

    function testRenderCodeToCss()
    {
        // compile SASS to compressed CSS
        $scss = $this->getScssInstance();

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

    function testRenderViewToCss()
    {
        // compile SASS (from file) to compressed CSS
        $scss = $this->getScssInstance();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss').'.scss';
        file_put_contents($scssFile, $code);

        $viewName = substr(basename($scssFile), 0, -5);

        $scss->setImportPath(dirname($scssFile));

        $this->assertEquals(
            '.footer{color:#444;}',
            $scss->renderViewToCss($viewName)
        );

        unlink($scssFile);
    }

    function testRenderFileToCssFile()
    {
        // compile SASS (from file) to compressed CSS (to file)
        $scss = $this->getScssInstance();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss').'.scss';
        file_put_contents($scssFile, $code);

        $scss->setImportPath(dirname($scssFile));

        $viewName = substr(basename($scssFile), 0, -5);

        $this->assertEquals(
            '.footer{color:#444;}',
            $scss->renderViewToCss($viewName)
        );

        unlink($scssFile);
    }

    function testIsValidViewName()
    {
        $scss = $this->getScssInstance();

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
