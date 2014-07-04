# About

Core3 is a small MVC framework, with mvc model implemented for
web application views through the Web\RequestRouter, cli views
(through the Cli\ApplicationRouter) and REST api views.


## Core3 directory structure

    api/            API views
    class/          Class files
    class/Model/    Models
    class/Client/   Network clients
    class/Writer/   Data writers
    cli/            CLI views

    data/           Data files
    doc/            Documentation
    template/       Templates
    test/           PHPUnit tests
    vendor/         Composer dependencies


## Application directory structure

    api/            Application API views
    class/          Application class files
    cli/            Application CLI views
    scss/           Application SCSS files
    test/           Application PHPUnit tests


## PDF support

Uses TCPDF via composer
