# TODO



# TODO cli
- task runner for the project, instead of the Makefile
  in order to automate things like db upgrade on the project's configured db,
  run benchmarks (currently: phpunit --group Benchmark)

- tool that verifies all tables & columns exist. use reflection to find all
  classes extending from PdoTable, use their public variables as column names,
  verify db structure!




# TODO db
- Not passing the PDO::PARAM_INT parameter when binding integer variables can
  sometimes cause PDO to quote them. This can screw up certain MySQL queries.
  See this bug report.  https://bugs.php.net/bug.php?id=44639




# TODO pdf support


# TODO tests
- maybe use php 5.5's cli webserver to test stuff?
  http://se2.php.net/manual/en/features.commandline.webserver.php

# TODO linter
- php: complain about trailing whitespace
- xml: add linter for test/*.xml, view/*.html



# TODO setup
- try installing and running everything from win7
- NAMESPACES: follow https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
	The fully qualified class name MUST have a top-level namespace name, also known as a "vendor namespace".
	
