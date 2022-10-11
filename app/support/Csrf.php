<?php

namespace app\support;

use app\core\Request;
use Exception;

class Csrf
{
    public static function csrf()
    {
        if (isset($_SESSION['token']))
            unset($_SESSION['token']);

        $_SESSION['token'] = md5(uniqid());

        return "<input type='hidden' name='token' id='token' value='{$_SESSION['token']}'/>";
    }


    public static function validateToken()
    {
        if (!isset($_SESSION['token'])) {
            throw new Exception("Token inválido");
        }

        $token = Request::only('token')['token'];
        if ($_SESSION['token'] !== $token) {
            throw new Exception("Token inválido");
        }

        unset($_SESSION['token']);

        return true;
    }
}
