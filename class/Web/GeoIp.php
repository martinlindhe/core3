<?php
namespace Web;


/**
 * Queries the installed geoip database
 * see doc/GeoIp.md for more info
 */
class GeoIp
{
    public function getRecord($s)
    {
        return geoip_record_by_name($s);
    }

    public function getCountry($s)
    {
        return geoip_country_code_by_name($s);
    }

    public function getTimezone($s)
    {
        $r = $this->getRecord($s);
        return geoip_time_zone_by_country_and_region($r['country_code'], $r['region']);
    }

    public function getDatabaseVersions()
    {
        $dbs = array(
        'GEOIP_COUNTRY_EDITION'     => GEOIP_COUNTRY_EDITION,
        'GEOIP_REGION_EDITION_REV0' => GEOIP_REGION_EDITION_REV0,
        'GEOIP_CITY_EDITION_REV0'   => GEOIP_CITY_EDITION_REV0,
        'GEOIP_ORG_EDITION'         => GEOIP_ORG_EDITION,
        'GEOIP_ISP_EDITION'         => GEOIP_ISP_EDITION,
        'GEOIP_CITY_EDITION_REV1'   => GEOIP_CITY_EDITION_REV1,
        'GEOIP_REGION_EDITION_REV1' => GEOIP_REGION_EDITION_REV1,
        'GEOIP_PROXY_EDITION'       => GEOIP_PROXY_EDITION,
        'GEOIP_ASNUM_EDITION'       => GEOIP_ASNUM_EDITION,
        'GEOIP_NETSPEED_EDITION'    => GEOIP_NETSPEED_EDITION,
        'GEOIP_DOMAIN_EDITION'      => GEOIP_DOMAIN_EDITION,
        );

        $res = array();

        foreach ($dbs as $name => $id)
        {
            if (!geoip_db_avail($id)) {
                continue;
            }

            $info = geoip_database_info($id);

            $x = explode(' ', $info);

            $res[] = array(
            'name' => $name,
            'file' => geoip_db_filename($id),
            'date' => $x[1], //sql_date( ts($x[1]) ),
            'version' => $x[0]
            );
        }

        return $res;
    }
}
