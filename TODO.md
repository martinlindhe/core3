# TODO
- get HttpUserAgent from core_dev?
- PHP 5.3 requirement means that namespace CAN be used





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
- OPEN PATCH: https://sourceforge.net/p/tcpdf/patches/70/
  first: drop lib/tcpdf when bugs are resolved, 2014-05-20
  then: use composer version of tcpdf when bugs are resolved


# TODO linter
- php: complain about trailing whitespace
- xml: add linter for test/*.xml



# TODO setup
- use composer version of phpunit in Makefile
- try installing and running everything from win7
