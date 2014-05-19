<?php

class Core_User extends Model_DatabaseTable
{
	public static $tableName = 'CoreUser';

	var $id;
	var $username;
	var $password;
}
