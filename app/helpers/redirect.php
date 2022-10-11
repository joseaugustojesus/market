<?php

use app\support\Uri;

function redirect(string $to)
{
    header("Location: {$to}");
    exit();
}


function route($route)
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;
    if ($route === '/') $route = '';
    return $baseUrl = $request_scheme . '/' . $route;
}


function url_is($uri)
{
    return Uri::get() === $uri;
}


function url_back()
{
    if (isset($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
    return '#';
}
