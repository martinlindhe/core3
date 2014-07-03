## Password handling

All passwords are hashed using the bcrypt algorithm,

Using the new php 5.5 function password_hash(),
or password_compat in order to be compatible with PHP 5.3.7+

In order to get a suggested cost parameter to use with bcrypt, run

  core3/cli.php bcrypt-find-cost

  > Appropriate password_hash() cost found: 12
