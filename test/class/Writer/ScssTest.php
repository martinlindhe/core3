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
        $cssFile = tempnam(sys_get_temp_dir(), 'css');

        file_put_contents($scssFile, $code);
        
        $scss->setImportPath(dirname($scssFile));
        
        $scss->renderFileToCssFile($scssFile, $cssFile);

        $this->assertEquals(
            '.footer{color:#444;}',
            file_get_contents($cssFile)
        );
        
        unlink($scssFile);
        unlink($cssFile);
    }

    /**
     * @expectedException \DirectoryNotFoundRexception
     */
    function testRenderFileToCssFileInvalidDstDir()
    {
        $scss = new \Writer\Scss();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss');
        $cssFile = '/invalid/dst/dir/file.css';

        file_put_contents($scssFile, $code);

        $scss->setImportPath(dirname($scssFile));

        $scss->renderFileToCssFile($scssFile, $cssFile);

        unlink($scssFile); // XXX wont run due to exception
    }


    /**
     * @expectedException \WritePermissionDeniedException
     */
    function testRenderFileToCssFileNotWritableDstDir()
    {
        // tries to write to PHP_BINDIR (/usr/bin on OSX),
        // assuming it is not writable
        $scss = new \Writer\Scss();

        $code = '.footer { color: #222 * 2; }';

        $scssFile = tempnam(sys_get_temp_dir(), 'scss');
        $cssFile = PHP_BINDIR.'/file.css';

        file_put_contents($scssFile, $code);

        $scss->setImportPath(dirname($scssFile));

        $scss->renderFileToCssFile($scssFile, $cssFile);

        unlink($scssFile); // XXX wont run due to exception
    }
    
    function testIsValidViewName()
    {
        $scss = new \Writer\Scss();

        $this->assertEquals(true, $scss->isValidViewName('viewName'));
        $this->assertEquals(true, $scss->isValidViewName('viewName111'));
        $this->assertEquals(true, $scss->isValidViewName('view-name'));

        $this->assertEquals(false, $scss->isValidViewName('view_name'));
        $this->assertEquals(false, $scss->isValidViewName('view+name'));
        $this->assertEquals(false, $scss->isValidViewName('view%name'));
        $this->assertEquals(false, $scss->isValidViewName('view,name'));
        $this->assertEquals(false, $scss->isValidViewName('view"name'));
        $this->assertEquals(false, $scss->isValidViewName('view\'name'));
    }

    /**
     * @expectedException \DirectoryNotFoundRexception
     */
    function testSetImportPathFailure()
    {
        $scss = new \Writer\Scss();
        $scss->setImportPath('/path/not/found');
    }

    function testSetImportPathSuccess()
    {
        $scss = new \Writer\Scss();
        $scss->setImportPath(__DIR__);
    }
}
