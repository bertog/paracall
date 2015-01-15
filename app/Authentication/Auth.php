<?php


namespace Paracall\Authentication;


use Paracall\Models\User;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth {

    public static $LoggedUser;

    public static function attempt(UserCredentials $credentials)
    {
        try
        {
            $user = User::where('username', '=', $credentials->username)->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if ( password_verify($credentials->password, $user->password) ) {

            self::$LoggedUser = $user;

            $_SESSION['username'] = $user->username;

            return true;
        }

        throw new Exception('Invalid Username or password');

    }

    public static function hash($password, $method = PASSWORD_DEFAULT)
    {
        return password_hash($password, $method);
    }

    public static function check()
    {
        return isset($_SESSION['username']) ? true : false;
    }


}