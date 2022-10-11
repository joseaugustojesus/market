<?php

namespace app\core;

use app\routes\Routes;
use app\support\RequestType;
use app\support\Uri;

class ControllerParams
{
    public function get(string $router, string $middleware)
    {
        $uri = Uri::get();
        $routes = Routes::get();
        $requestMethod = RequestType::get();

        if($middleware) $router = "{$router}:{$middleware}";
        $router = array_search($router, $routes[$requestMethod]);
        

        $explodeUri = array_filter(explode('/', $uri));
        $explodeRouter = array_filter(explode('/', $router));


        $params = [];
        foreach ($explodeRouter as $index => $routerSegment) {
            if($routerSegment !== $explodeUri[$index]){
                $params[$index] = $explodeUri[$index];
            }
        }
        return $params;
    }
}
