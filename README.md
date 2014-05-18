# About

Hello


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


TODO db:
    Not passing the PDO::PARAM_INT parameter when binding integer variables can sometimes cause PDO to quote them. This can screw up certain MySQL queries. See this bug report.  https://bugs.php.net/bug.php?id=44639


