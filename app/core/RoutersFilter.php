<?php

namespace app\core;

use app\routes\Routes;
use app\support\RequestType;
use app\support\Uri;

class RoutersFilter
{

    private  $uri;
    private  $method;
    private $routesRegistered;

    public function __construct()
    {
        $this->uri = Uri::get();
        $this->method = RequestType::get();
        $this->routesRegistered = Routes::get();
    }

    private function simpleRouter()
    {
    	//dd($this->uri, $this->routesRegistered, $this->method);
        if (array_key_exists($this->uri, $this->routesRegistered[$this->method])) {
            return $this->routesRegistered[$this->method][$this->uri];
        }

        return null;
    }

    private function dynamicRouter()
    {
        $routerRegisteredFound = null;
        foreach ($this->routesRegistered[$this->method] as $index => $route) {
            $regex = str_replace('/', '\/', ltrim($index, '/'));
            if ($index !== '/' and preg_match("/^$regex$/", ltrim($this->uri, '/'))) {
                $routerRegisteredFound = $route;
                break;
            } else {
                $routerRegisteredFound = null;
            }
        }

        // dd('dinâmico', $routerRegisteredFound, $this->routesRegistered, $this->method);
        return $routerRegisteredFound;
    }


    public function get()
    {

        $router = $this->simpleRouter();
        if ($router) return $router;


        $router = $this->dynamicRouter();
        if ($router) return $router;

        return null;
    }
}
