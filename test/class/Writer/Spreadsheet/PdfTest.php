<?php
namespace Core3\Writer\Spreadsheet;

/**
* @group HhvmIncompatible
 * @group Writer
 */
class PdfTest extends \PHPUnit_Framework_TestCase
{
    function testHttpHeaders()
    {
        // NOTE: for header() testing to work, we must run phpunit with --stderr

        $writer = new Pdf();
        $fileName = 'file_'.mt_rand().'.pdf';
        $writer->sendHttpAttachmentHeaders($fileName);

        $this->assertEquals(
            array('application/pdf'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Type')
        );

        $this->assertEquals(
            array('attachment; filename="'.$fileName.'"'),
            \Core3\Debug\XdebugExtras::findHeaders('Content-Disposition')
        );

        $this->assertEquals(
            array('no-cache'),
            \Core3\Debug\XdebugExtras::findHeaders('Pragma')
        );

        $this->assertEquals(
            array('Sat, 26 Jul 1997 05:00:00 GMT'),
            \Core3\Debug\XdebugExtras::findHeaders('Expires')
        );
    }

    function testUsageExample()
    {
        $model = new \Core3\Model\Spreadsheet();
        $model->defineColumns(array('id', 'name'));
        $model->addRow(array('1', 'kalle'));
        $model->addRow(array('2', 'olle'));

        $writer = new Pdf();
        $writer->setCreator('custom framework 1.0');
        $writer->setAuthor('Mr Cool');
        $writer->setTitle('Document title');
        $writer->setSubject('Document subject');
        $writer->addKeywords(array('cool', 'stuff', 'testing'));
        $data = $writer->render($model);

        $this->assertGreaterThan(1000, strlen($data), 'Some data was returned');

        $reader = new \Core3\Reader\BinaryData\Document();
        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isPdfData($data));
    }

    private function createJpeg($toFile)
    {
        $image = imagecreate(200, 40);

        // set up some colors, use a dark gray as the background color
        $darkGrey = imagecolorallocate($image, 102, 102, 102);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagestring($image, 3, 0, 0, 'Hello World!', $white);

        imagejpeg($image, $toFile);

        imagedestroy($image);
    }

    function testEmbedHtmlImage()
    {
        // NOTE: to embed images, use <img src=""> tag but specify a path to an existing file

        $model = new \Core3\Model\Spreadsheet();
        $model->defineColumns(array('id', 'name'));
        $model->addRow(array('1', 'kalle'));
        $model->addRow(array('2', 'olle'));

        $imgFile = tempnam('/tmp', 'embedHtmlImage');

        $this->createJpeg($imgFile);

        $writer = new Pdf();
        $writer->setStartHtmlBlock('<img src="'.$imgFile.'"/><br/>');
        $writer->setEndHtmlBlock('<h2>GOODBYE</h2>');

        $data = $writer->render($model);

        unlink($imgFile);

        $reader = new \Core3\Reader\BinaryData\Document();
        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isPdfData($data));
    }
}
