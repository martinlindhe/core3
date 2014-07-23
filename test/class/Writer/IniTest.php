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

        $iniStructure = \Reader\Ini::parse($data);
        $iniStructure->set('Section', 'key1', 'kalle');

        $this->assertEquals(
            "[Section]\n".
            ";comment\n".
            "\n".
            "key1=kalle\n".
            "key2=other\n",
            \Writer\Ini::render($iniStructure)
        );
    }
}
