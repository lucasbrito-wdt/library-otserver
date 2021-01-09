<?php

namespace Otserver;

use Illuminate\Support\Facades\Session;

class Visitor extends Session
{
    const LOGINSTATE_NOT_TRIED = 1;
    const LOGINSTATE_NO_ACCOUNT = 2;
    const LOGINSTATE_WRONG_PASSWORD = 3;
    const LOGINSTATE_LOGGED = 4;

    private static $loginAccount;
    private static $loginPassword;
    private static $account;
    private static $loginState = self::LOGINSTATE_NOT_TRIED;

    public function __construct()
    {
        self::login();
    }

    public static function setAccount($value)
    {
        Session::put(['account' => $value]);
    }

    public static function setPassword($value)
    {
        Session::put(['password' => $value]);
    }

    public static function setAccountLoaded($account)
    {
        if (Session::has('accountLogged'))
            Session::remove('accountLogged');
        Session::put(['accountLogged' => $account]);
    }

    public static function setLoginState($state)
    {
        Session::put(['loginState' => $state]);
    }

    public static function getAccount()
    {
        if (Session::has('accountLogged'))
            self::$account = Session::get('accountLogged');
        if (!isset(self::$account))
            self::loadAccount();
        return self::$account;
    }

    public static function loadAccount()
    {
        self::$account = new Account();
        if (!empty(self::$loginAccount)) {
            self::$account->loadByName(self::$loginAccount);
            if (self::$account->isLoaded())
                if (self::$account->isValidPassword(self::$loginPassword)) {
                    self::$loginState = self::LOGINSTATE_LOGGED;

                    self::setAccountLoaded(self::$account);
                    self::setLoginState(self::$loginState);
                } else {
                    self::$loginState = self::LOGINSTATE_WRONG_PASSWORD;
                    self::setLoginState(self::$loginState);
                }
            else {
                self::$loginState = self::LOGINSTATE_NO_ACCOUNT;
                self::setLoginState(self::$loginState);
            }
        } else {
            self::$loginState = self::LOGINSTATE_NOT_TRIED;
            self::setLoginState(self::$loginState);
        }

        if (self::$loginState != self::LOGINSTATE_LOGGED)
            self::$account = new Account();
    }

    public static function isTryingToLogin()
    {
        if (Session::has('account'))
            self::$loginAccount = Session::get('account');
        return !empty(self::$loginAccount);
    }

    public static function getLoginState()
    {
        if (Session::has('loginState'))
            self::$loginState = Session::get('loginState');

        return self::$loginState;
    }

    public static function isLogged()
    {
        return self::isTryingToLogin() && Session::has('accountLogged');
    }

    public static function login()
    {
        if (Session::has('account'))
            self::$loginAccount = Session::get('account');
        if (Session::has('password'))
            self::$loginPassword = Session::get('password');
        return self::getAccount();
    }

    public static function logout()
    {
        Session::remove('account');
        Session::remove('password');
        Session::remove('accountLogged');
        Session::remove('loginState');

        self::$loginAccount = null;
        self::$loginPassword = null;
        self::$account = new Account();
        self::$loginState = self::LOGINSTATE_NOT_TRIED;
    }

    public static function getIP()
    {
        return ip2long($_SERVER['REMOTE_ADDR']);
    }
}
