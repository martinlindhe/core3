<?php
/**
 * @group Reader
 */

class Reader_BinaryData_ImageTest extends PHPUnit_Framework_TestCase
{
    function testRecognizeGif()
    {
        $imageFile = tempnam('/tmp', 'tmpImage');

        $image = imagecreate(1, 1);
        imagegif($image, $imageFile);
        imagedestroy($image);

        $data = file_get_contents($imageFile);
        unlink($imageFile);

        $reader = new Reader_BinaryData_Image();

        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isGifData($data));
        $this->assertEquals(false, $reader->isJpegData($data));
        $this->assertEquals(false, $reader->isPngData($data));
    }

    function testRecognizeJpeg()
    {
        $imageFile = tempnam('/tmp', 'tmpImage');

        $image = imagecreate(1, 1);
        imagejpeg($image, $imageFile);
        imagedestroy($image);

        $data = file_get_contents($imageFile);
        unlink($imageFile);

        $reader = new Reader_BinaryData_Image();

        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isJpegData($data));
        $this->assertEquals(false, $reader->isPngData($data));
        $this->assertEquals(false, $reader->isGifData($data));
    }

    function testRecognizePng()
    {
        $imageFile = tempnam('/tmp', 'tmpImage');

        $image = imagecreatetruecolor(1, 1);
        imagepng($image, $imageFile);
        imagedestroy($image);

        $data = file_get_contents($imageFile);
        unlink($imageFile);

        $reader = new Reader_BinaryData_Image();

        $this->assertEquals(true, $reader->isRecognized($data));
        $this->assertEquals(true, $reader->isPngData($data));
        $this->assertEquals(false, $reader->isJpegData($data));
        $this->assertEquals(false, $reader->isGifData($data));
    }

    function testUnrecognizedData()
    {
        $data = str_repeat(chr(0x12).chr(0x13).chr(0xFF).chr(0x20), 500);

        $reader = new Reader_BinaryData_Image();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPngData($data));
        $this->assertEquals(false, $reader->isJpegData($data));
        $this->assertEquals(false, $reader->isGifData($data));
    }

    function testUnrecognizedTinyData()
    {
        $data = chr(0x12).chr(0x13).chr(0xFF).chr(0x20);

        $reader = new Reader_BinaryData_Image();

        $this->assertEquals(false, $reader->isRecognized($data));
        $this->assertEquals(false, $reader->isPngData($data));
        $this->assertEquals(false, $reader->isJpegData($data));
        $this->assertEquals(false, $reader->isGifData($data));
    }

}
