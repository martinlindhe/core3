<?php
/**
 * @group Writer
 */

class Writer_SpreadsheetCsvTest extends PHPUnit_Framework_TestCase
{
	function testHttpHeaders()
	{
		// NOTE: for header() testing to work, we must run phpunit with --stderr

		$fileName = 'file_'.mt_rand().'.csv';

		$writer = new Writer_SpreadsheetCsv();
		$writer->sendHttpAttachmentHeaders($fileName);

		$this->assertEquals( array('text/csv'), xdebug_find_headers('Content-Type'));
		$this->assertEquals( array('attachment; filename="'.$fileName.'"'), xdebug_find_headers('Content-Disposition'));
		$this->assertEquals( array('no-cache'), xdebug_find_headers('Pragma'));
		$this->assertEquals( array('Sat, 26 Jul 1997 05:00:00 GMT'), xdebug_find_headers('Expires'));
	}

	function testUsage1()
	{
		// NOTE shows basic usage

		$model = new Model_Spreadsheet();
		$model->defineColumns( array('id', 'col 2', 'date_stamp') );
		$model->addRow( array(37, 'hej', '2000-05-05') );
		$model->addRow( array(38, 'nej', '2000-05-06') );

		$writer = new Writer_SpreadsheetCsv();

		$this->assertEquals(
			$writer->render($model),
			'id;col 2;date_stamp'."\r\n".
			'37;hej;2000-05-05'."\r\n".
			'38;nej;2000-05-06'."\r\n"
		);
	}

	function testUsage2()
	{
		// NOTE shows how to add multiple rows at once, without a header

		$data = array(
				array(1, "kalle"),
				array(2, "pelle"),
				array(3, "lisa")
			);

		$model = new Model_Spreadsheet();
		$model->addRows( $data );

		$writer = new Writer_SpreadsheetCsv();

		$this->assertEquals(
			$writer->render($model),
			'1;kalle'."\r\n".
			'2;pelle'."\r\n".
			'3;lisa'."\r\n"
		);
	}

	function testRequiredEscaping()
	{
		// NOTE verifies that columns with special characters are escaped properly

		$model = new Model_Spreadsheet();
		$model->defineColumns( array('ti,tel', 'namn', 'datum', 'antal') );
		$model->addRow( array('a 1', 'böp,på', 'cdwd', 'devef'));

		$writer = new Writer_SpreadsheetCsv();
		$writer->setLineEnding("\n");

		$this->assertEquals(
			$writer->render($model),
			'"ti,tel";namn;datum;antal'."\n".
			'a 1;"böp,på";cdwd;devef'."\n"
		);
	}

	function testEscapedString1()
	{
		$writer = new Writer_SpreadsheetCsv();
		$this->assertEquals(
			'"test""str"',
			$writer->escapeString('test"str')
		);
	}

	function testEscapedString2()
	{
		$writer = new Writer_SpreadsheetCsv();
		$this->assertEquals(
			'"test,str"',
			$writer->escapeString('test,str')
		);
	}

	function testEscapedString3()
	{
		$writer = new Writer_SpreadsheetCsv();
		$this->assertEquals(
			'"test;str"',
			$writer->escapeString('test;str')
		);
	}

	function testEscapedStringContainsPadding()
	{
		$writer = new Writer_SpreadsheetCsv();
		$this->assertEquals(
			'" test "',
			$writer->escapeString(' test ')
		);
	}

	function testEscapedStringContainsLineFeed()
	{
		$writer = new Writer_SpreadsheetCsv();
		$this->assertEquals(
			"\"line1\nline2\"",
			$writer->escapeString("line1\nline2")
		);
	}
}
