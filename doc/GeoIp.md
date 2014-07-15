== Install on Debian

  sudo apt-get php5-geoip geoip-database-contrib

the geoip-database-contrib keeps local database up-to-date


== Install on MAC
*   brew install homebrew/php/php54-geoip

then add to /etc/php.ini:

```
[geoip]
extension="/usr/local/Cellar/php54-geoip/1.0.8/geoip.so"
```

The data files are available at
  http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
  http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
  http://geolite.maxmind.com/download/geoip/database/GeoIPv6.dat.gz
