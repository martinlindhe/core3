# About

Hello


## Directory structure


    class/          Class files
    class/Model/    Models
    class/Client/   Network clients
    class/Writer/   Data writers

    data/           Data files
    test/           PHPUnit tests
    vendor/         Composer dependencies




## Password hashing

Uses the new php 5.5 function password_hash(), or password_compat in order to be
compatible with PHP 5.3.7+
The bcrypt algorithm is used

In order to get a suggested cost parameter to use with bcrypt, run

  make benchmark

  > Appropriate password_hash() cost found: 12




## PDF support

Uses TCPDF 6.0.080 via composer
