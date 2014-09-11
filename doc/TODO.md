# TODO wiki

 * maybe fully render text client side instead?
 * show historu
 * edit wiki
 * api file (POST/PUT/GET/DELETE)




# TODO cli
- tool that verifies all tables & columns exist. use reflection to find all
  classes extending from PdoTable, use their public variables as column names,
  verify db structure!


- task runner for the project, instead of the Makefile
  in order to automate things like db upgrade on the project's configured db




# TODO db
- Not passing the PDO::PARAM_INT parameter when binding integer variables can
  sometimes cause PDO to quote them. This can screw up certain MySQL queries.
  See this bug report.  https://bugs.php.net/bug.php?id=44639



# TODO scss
- WISH: scssphp dont support scss 3.3 features, like "More Flexible &":
    http://blog.sass-lang.com/posts/184094-sass-33-is-released






# TODO js minify support
- uses uglify-js
- make task for creating min & map files of everything in js dir



# TODO linter
- phpcs: disable warning for <?=, php 5.4 no longer considers this a "short tag" and is encouraged
