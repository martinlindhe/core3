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



##### TODO

TODO: cli task runner for the project


TODO:
    cli tool that verifies all tables & columns exist. use reflection to find all classes extending from PdoTable, use their public variables as column names,
    verify db structure!


TODO db:
    Not passing the PDO::PARAM_INT parameter when binding integer variables can sometimes cause PDO to quote them. This can screw up certain MySQL queries. See this bug report.  https://bugs.php.net/bug.php?id=44639


TODO get HttpUserAgent from core_dev
