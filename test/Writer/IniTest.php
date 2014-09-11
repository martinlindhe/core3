<?php

class WriterIniTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndRender()
    {
        // NOTE tests that comments and empty lines are unchanged
        $data = "[Section]\n".
            ";comment\n".
            "\n".
            "key1=val\n".
            "key2=other\n";

        $iniStructure = \Core3\Reader\Ini::parse($data);
        $iniStructure->set('Section', 'key1', 'kalle');

        $this->assertEquals(
            "[Section]\n".
            ";comment\n".
            "\n".
            "key1=kalle\n".
            "key2=other\n",
            \Core3\Writer\Ini::render($iniStructure)
        );
    }

    public function testWriteToEmpty()
    {
        // NOTE fills empty ini file
        $iniStructure = \Core3\Reader\Ini::parse("");
        $iniStructure->set('Section', 'key1', 'kalle');

        $this->assertEquals(
            "[Section]\n".
            "key1=kalle\n",
            \Core3\Writer\Ini::render($iniStructure)
        );
    }

    public function testWriteMultipleKeys()
    {
        $iniStructure = \Core3\Reader\Ini::parse("");

        for ($i = 0; $i < 5; $i++) {
            $iniStructure->set('Section', 'n'.$i, $i);
        }

        $this->assertEquals(
            "[Section]\n".
            "n0=0\n".
            "n1=1\n".
            "n2=2\n".
            "n3=3\n".
            "n4=4\n",
            \Core3\Writer\Ini::render($iniStructure)
        );
    }

    public function testWriteMultipleKeys2()
    {
        $iniStructure = \Core3\Reader\Ini::parse(
            "[Section1]\n".
            "n0=0\n"
        );


        $iniStructure->set('Section2', 'n1', 1);

        $this->assertEquals(
            "[Section1]\n".
            "n0=0\n".
            "\n".
            "[Section2]\n".
            "n1=1\n",
            \Core3\Writer\Ini::render($iniStructure)
        );
    }
}
