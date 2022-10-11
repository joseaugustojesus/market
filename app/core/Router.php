<?php

namespace app\core;

use Exception;

class Router
{
    public static function run()
    {
        try {
            $routerRegistered = new RoutersFilter;
            $router = $routerRegistered->get();


            $middleware = '';
            if ($router) {
                if (string_contains($router, ':')) {
                    [$router, $middleware] = explode(':', $router);
                }
            }else{
                throw new Exception("A rota informada não existe");
            }



            $controller = new Controller;
            $controller->execute($router, $middleware);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
