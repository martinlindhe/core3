<?php
/**
 * @group Present
 */
class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $this->assertEquals(
            '2010-01-01T22:11:39+00:00',
            (new \Present\DateTime(strtotime('2010-01-01 22:11:39')))->render()
        );
    }

    public function testLocalizedRenderSwedish()
    {
        $this->assertEquals(
            '2010-01-01 22:11:39',
            \Present\DateTime::localized('sv_se', strtotime('2010-01-01 22:11:39'))
        );
    }
}
