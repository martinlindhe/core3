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





## PDF support

tcpdf 6.0.078 (released 2014-05-12) is shipped in lib/tcpdf
Licence: GPL
Source: http://sourceforge.net/projects/tcpdf/files/

RATIONALE FOR TCPDF: tcpdf supports HTML to PDF, which is required; haru does not
