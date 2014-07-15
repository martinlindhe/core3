<?php

class GeoIpTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCountry()
    {
        $geoip = new \Web\GeoIp();
        $this->assertEquals('SE', $geoip->getCountry('www.ica.se'));
    }

    public function testGetTimezone()
    {
        $geoip = new \Web\GeoIp();
        $this->assertEquals('Europe/Stockholm', $geoip->getTimezone('www.stockholm.se'));
    }

    public function testGetRecord1()
    {
        $geoip = new \Web\GeoIp();
        $res = $geoip->getRecord('www.whitehouse.gov');

        // NOTE this may not always hold true
        $this->assertEquals('United States', $res['country_name']);
        $this->assertEquals('MA', $res['region']);
        $this->assertEquals('Cambridge', $res['city']);
    }
/*
    public function testGetDatabaseVersions()
    {
        $geoip = new \Web\GeoIp();
        var_dump($geoip->getDatabaseVersions());
    }
*/
}
