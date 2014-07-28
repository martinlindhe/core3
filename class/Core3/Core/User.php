<?php
namespace Core3\Core;

class User extends \Core3\Model\DatabaseTable
{
    public static $tableName = 'CoreUser';

    var $id;
    var $username;
    var $password;
}
