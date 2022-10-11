<?php




function css_path($path = '')
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}/" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;

    return $request_scheme . "/public/css{$path}";
}


function js_path($path = '')
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}/" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;
    return $request_scheme  . "/public/js{$path}";
}

function uploads_path($path = '')
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}/" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;
    return $request_scheme  . "/public/uploads{$path}";
}

function base_url()
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}/" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;
    dd($request_scheme);
    return $request_scheme;
}




function image_path($image)
{
    $request_scheme = $_SERVER['SERVER_NAME'] === 'localhost' ? "http://localhost:{$_SERVER['SERVER_PORT']}/" : $_SERVER['REQUEST_SCHEME'] . '://' . URL_BASE;
    return $request_scheme  . '/public/images/' . $image;
}
