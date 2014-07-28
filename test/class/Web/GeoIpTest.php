<?php
/**
 * @group HhvmIncompatible
 * @group Web
 */
class GeoIpTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCountry()
    {
        $geoip = new \Core3\Web\GeoIp();
        $this->assertEquals('SE', $geoip->getCountry('www.ica.se'));
    }

    public function testGetTimezone()
    {
        $geoip = new \Core3\Web\GeoIp();
        $this->assertEquals('Europe/Stockholm', $geoip->getTimezone('www.stockholm.se'));
    }

    public function testGetRecord1()
    {
        $geoip = new \Core3\Web\GeoIp();
        $res = $geoip->getRecord('8.8.8.8');
        $this->assertInstanceOf('\Core3\Web\GeoIpRecord', $res);
        $this->assertEquals(38, $res->latitude);
        $this->assertEquals(-97, $res->longitude);
    }

    public function testGetRecord2()
    {
        $geoip = new \Core3\Web\GeoIp();
        $res = $geoip->getRecord('www.whitehouse.gov');
        $this->assertInstanceOf('\Core3\Web\GeoIpRecord', $res);

        // NOTE this may not always hold true
        $this->assertEquals('United States', $res->countryName);
        $this->assertEquals('MA', $res->region);
        $this->assertEquals('Cambridge', $res->city);
        $this->assertEquals(42.362598419189, $res->latitude);
        $this->assertEquals(-71.084297180176, $res->longitude);
    }
/*
    public function testGetDatabaseVersions()
    {
        // BUG crashes php 5.4 & 5.6rc2 on mac
        $geoip = new \Core3\Web\GeoIp();
        var_dump($geoip->getDatabaseVersions());
    }
*/
}
