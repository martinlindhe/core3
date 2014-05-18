<?php

// NOTE password_hash() requires php 5.5 or https://github.com/ircmaxell/password_compat.git

class Core_Password
{
    /**
     * @return 60-byte string with password hash
     */
    public static function hash($password, $cost = 10)
    {
        $options = array(
        'cost' => $cost,
        );

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Verifies if entered password equals stored password hash
     * @return bool
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Checks against password blacklist wether input
     * is allowed for use as
     */
    public static function isAllowed($password)
    {
        // disallow repeated letter strings
        if (str_repeat(substr($password, 0, 1), strlen($password)) == $password) {
            return false;
        }

        $chk_file = dirname(__FILE__).'/../../data/Password.forbidden.txt';
        if (!file_exists($chk_file))
            throw new \Exception ('file not found '.$chk_file);

        $data = file_get_contents($chk_file);

        return strpos($data, (strtolower($password)) ) === false;
    }

}

