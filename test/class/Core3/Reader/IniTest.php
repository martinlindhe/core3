<?php

class ReaderIniTest extends \PHPUnit_Framework_TestCase
{
    public function testParseAndGetAndSet()
    {
        $data = "[Section]\n".
            "key1=val\n".
            "key2=other\n";

        $iniStructure = \Core3\Reader\Ini::parse($data);

        $this->assertInstanceOf('\Core3\Structure\IniFile', $iniStructure);

        $this->assertEquals('val', $iniStructure->get('Section', 'key1'));
        $this->assertEquals('other', $iniStructure->get('Section', 'key2'));

        $iniStructure->set('Section', 'key1', 'kalle');
        $this->assertEquals('kalle', $iniStructure->get('Section', 'key1'));
    }
}
