<?php
/**
 * @group Writer
 */

class Writer_SpreadsheetPdfTest extends PHPUnit_Framework_TestCase
{
	function testHttpHeaders()
	{
		// NOTE: for header() testing to work, we must run phpunit with --stderr

		$fileName = 'file_'.mt_rand().'.pdf';
		Writer_SpreadsheetPdf::sendHttpAttachmentHeaders($fileName);

		$this->assertEquals( array('application/pdf'), xdebug_find_headers('Content-Type'));
		$this->assertEquals( array('attachment; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
		$this->assertEquals( array('no-cache'), xdebug_find_headers('Pragma'));
		$this->assertEquals( array('Sat, 26 Jul 1997 05:00:00 GMT'), xdebug_find_headers('Expires'));
	}

	function testUsageExample()
	{
		$model = new Model_Spreadsheet();
		$model->defineColumns( array('id', 'name') );
		$model->addRow( array('1', 'kalle') );
		$model->addRow( array('2', 'olle') );

		$writer = new Writer_SpreadsheetPdf();
		$writer->setCreator('custom framework 1.0');
		$writer->setAuthor('Mr Cool');
		$writer->setTitle('Document title');
		$writer->setSubject('Document subject');
		$writer->addKeywords( array('cool', 'stuff', 'testing') );
		$data = $writer->render($model);

		$this->assertGreaterThan( 1000, strlen($data), 'Some data was returned' );

		// TODO: verify generated document, requires PDF & PS Readers
	}

	private function createJpeg($toFile)
	{
		$image = imagecreate(200, 40);

		// set up some colors, use a dark gray as the background color
		$dark_grey = imagecolorallocate($image, 102, 102, 102);
		$white = imagecolorallocate($image, 255, 255, 255);

		imagestring($image, 3, 0, 0, 'Hello World!', $white);

		imagejpeg($image, $toFile);

		imagedestroy($image);
	}

	function testEmbedHtmlImage()
	{
		// NOTE: to embed images, use <img src=""> tag but specify a path to an existing file

		$model = new Model_Spreadsheet();
		$model->defineColumns( array('id', 'name') );
		$model->addRow( array('1', 'kalle') );
		$model->addRow( array('2', 'olle') );

		$imgFile = tempnam('/tmp', 'embedHtmlImage');

		$this->createJpeg($imgFile);

		$writer = new Writer_SpreadsheetPdf();
		$writer->setStartHtmlBlock('<img src="'.$imgFile.'"/><br/>');
		$writer->setEndHtmlBlock('<h2>GOODBYE</h2>');

		$data = $writer->render($model);

		unlink($imgFile);

		//file_put_contents('out.pdf', $data);
	}

}
