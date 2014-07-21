<?php
/**
 * @group Present
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $this->assertEquals(
            '2010-01-01',
            (new \Present\Date(strtotime('2010-01-01')))->render()
        );
    }

    public function testLocalizedRenderDateSwedish()
    {
        $this->assertEquals(
            '2010-01-01',
            \Present\Date::localized('sv_se', strtotime('2010-01-01'))
        );
    }
}
