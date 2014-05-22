<?php
namespace Core;

class User extends \Model\DatabaseTable
{
    public static $tableName = 'CoreUser';

    var $id;
    var $username;
    var $password;
}
