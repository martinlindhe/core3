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
            (new \Core3\Present\DateTime(strtotime('2010-01-01 22:11:39')))->render()
        );
    }

    public function testLocalizedSwedish()
    {
        $this->assertEquals(
            '2010-01-01 22:11:39',
            \Core3\Present\DateTime::localized('sv_SE', strtotime('2010-01-01 22:11:39'))
        );
    }

    public function testLocalizedGerman()
    {
        $this->assertEquals(
            '2010-01-01 22:11:39',
            \Core3\Present\DateTime::localized('de_DE', strtotime('2010-01-01 22:11:39'))
        );
    }

    public function testLocalizedAmerican()
    {
        $this->assertEquals(
            '01/01/2010 10:11:39 PM',
            \Core3\Present\DateTime::localized('en_US', strtotime('2010-01-01 22:11:39'))
        );
    }
}
