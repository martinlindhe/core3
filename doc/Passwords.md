## Password handling

All passwords are hashed using the bcrypt algorithm,

Using the new php 5.5 function password_hash(),
or password_compat in order to be compatible with PHP 5.3.7+

In order to get a suggested cost parameter to use with bcrypt, run

  core3/cli.php bcrypt-find-cost

  > Appropriate password_hash() cost found: 12


## Authentication

Js auth impl:

check http://www.kdelemme.com/2014/03/09/authentication-with-angularjs-and-a-node-js-rest-api/

TODO:
    1. server send "cost" param to client (= 10)
    2. client randomizes a salt
    3. client uses salt & bcrypts pwd in browser, sending over result
    4. server uses password_verify()

    XXX: over the air-bcrypt data would be the same as stored in db, bad?
    XXX2: if server instead calc sha512 of client bcrypt, then client data
        and server db will not match. is this relevant?
