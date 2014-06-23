# TODO



# TODO cli
- task runner for the project, instead of the Makefile
  in order to automate things like db upgrade on the project's configured db,
  run benchmarks (currently: phpunit --group Benchmark)

- tool that verifies all tables & columns exist. use reflection to find all
  classes extending from PdoTable, use their public variables as column names,
  verify db structure!



# TODO api
	


# TODO db
- Not passing the PDO::PARAM_INT parameter when binding integer variables can
  sometimes cause PDO to quote them. This can screw up certain MySQL queries.
  See this bug report.  https://bugs.php.net/bug.php?id=44639



# TODO scss (compiled css) support
- refactor core3_app scss.php view stuff into Writer/Scss class






# TODO js minify support
- uses uglify-js
- make task for creating min & map files of everything in js dir


# TODO tests


# TODO linter
- phpcs: disable warning for <?=, php 5.4 no longer considers this a "short tag" and is encouraged



# TODO setup
- try installing and running everything from win7
- NAMESPACES: follow https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
	The fully qualified class name MUST have a top-level namespace name, also known as a "vendor namespace".

