# About

Hello


## Directory structure


    class/          Class files
    class/Model/    models
    class/Client/   network clients
    class/Writer/   data writers

    tests/          PHPUnit tests




##### TODO

TODO: cli task runner for the project

TODO: use composer for php dependencies?!??!!?


    cli tool that verifies all tables & columns exist. use reflection to find all classes extending from PdoTable, use their public variables as column names,
    verify db structure!


TODO db:
    Not passing the PDO::PARAM_INT parameter when binding integer variables can sometimes cause PDO to quote them. This can screw up certain MySQL queries. See this bug report.  https://bugs.php.net/bug.php?id=44639



TODO use these standard "must reload page" headers:
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');




