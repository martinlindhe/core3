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
            (new \Core3\Present\Date(strtotime('2010-01-01')))->render()
        );
    }

    public function testLocalizedSwedish()
    {
        $this->assertEquals(
            '2010-01-01',
            \Core3\Present\Date::localized('sv_SE', strtotime('2010-01-01'))
        );
    }

    public function testLocalizedGerman()
    {
        $this->assertEquals(
            '2010-01-01',
            \Core3\Present\Date::localized('de_DE', strtotime('2010-01-01'))
        );
    }

    public function testLocalizedAmerican()
    {
        $this->assertEquals(
            '01/01/2010',
            \Core3\Present\Date::localized('en_US', strtotime('2010-01-01'))
        );
    }
}
