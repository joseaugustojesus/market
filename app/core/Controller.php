<?php

namespace app\core;

use Exception;

class Controller
{
    public function execute(string $router, string $middleware)
    {
        if (substr_count($router, '@') <= 0) {
            throw new Exception("A rota está registrada com o formato errado");
        }
        
        list($controller, $method) = explode('@', $router);
        $namespace = 'app\controllers\\';
        $controllerNamespace = "{$namespace}{$controller}";
        
        if(!class_exists($controllerNamespace)){
            throw new Exception("O controller ({$controllerNamespace}) não existe");
        }
        

        $controller = new $controllerNamespace;        
        if(!method_exists($controller, $method)){
            throw new Exception("O método ({$method}) não existe no controlador ({$controllerNamespace})");
        }

        if($middleware) $this->$middleware();

        $params = new ControllerParams;
        $params = $params->get($router, $middleware);
        $controller->$method(...$params);
    }


    private function authenticated()
    {
        $authenticated = isset($_SESSION['authenticated']);
        if(!$authenticated) return redirect(route('login'));
        return true;
    }
}
