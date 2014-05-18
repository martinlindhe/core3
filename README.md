# About

Hello



## Requirements


  php5-sqlite

### Password

  php 5.5, or



### Testing

PHPUnit 4.1


### PDF support

Relies on the tcpdf classes.

#### debian

  sudo apt-get install php-tcpdf


#### macports

(??)

  sudo port install pear-TCPDF





## Directory structure


    class/          Class files
    class/Model/    models
    class/Client/   network clients
    class/Writer/   data writers

    tests/          PHPUnit tests




##### TODO

    cli task runner for the project



    cli tool that verifies all tables & columns exist. use reflection to find all classes extending from PdoTable, use their public variables as column names,
    verify db structure!



