== Install on Debian

  sudo apt-get php5-geoip geoip-database-contrib

the geoip-database-contrib keeps local database up-to-date


== Install on MAC

    brew install php54-geoip --without-homebrew-php
*   brew install geoipupdate

then add to /etc/php.ini:

```
[geoip]
extension="/usr/local/Cellar/php54-geoip/1.0.8/geoip.so"
```

The data files are available at
  http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
  http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
  http://download.maxmind.com/download/geoip/database/asnum/GeoIPASNum.dat.gz

 IPv6
  http://geolite.maxmind.com/download/geoip/database/GeoIPv6.dat.gz
  http://geolite.maxmind.com/download/geoip/database/GeoLiteCityv6-beta/GeoLiteCityv6.dat.gz
  http://download.maxmind.com/download/geoip/database/asnum/GeoIPASNumv6.dat.gz


place them in /usr/local/var/GeoIP
