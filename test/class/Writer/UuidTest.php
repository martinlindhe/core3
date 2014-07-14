<?php

/**
 * @group Writer
 */
class UuidTest extends \PHPUnit_Framework_TestCase
{
    function testV3()
    {
        $this->assertEquals(
            '19d179a2-9511-3595-a8e2-490b981e92c2',
            \Writer\Uuid::v3('514d2ee9-58ed-49ef-a592-1a49c268e2a2', 'test crap 123')
        );
    }

    function testV5()
    {
        $this->assertEquals(
            'f1b18651-7633-5945-8527-853ddc5b6393',
            \Writer\Uuid::v5('514d2ee9-58ed-49ef-a592-1a49c268e2a2', 'test crap 123')
        );
    }

    function testV4random()
    {
        $this->assertEquals(
            36,  // random value, assert length
            strlen(\Writer\Uuid::v4())
        );
    }

    function testToHex()
    {
        $this->assertEquals(
            'E004253F894FD3119A0C0305E82C3301',
            \Writer\Uuid::toHex('3F2504E0-4F89-11D3-9A0C-0305E82C3301')
        );
    }
}
