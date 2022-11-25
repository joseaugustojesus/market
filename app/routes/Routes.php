<?php

namespace app\routes;


class Routes
{

    public static function get()
    {
        return [
            'get' => [
                '/' => 'LoginController@form',
                '/login' => 'LoginController@form',
                '/logout' => 'LoginController@logout',

                '/dashboard' => 'DashboardController@index:authenticated',
                '/products' => 'ProductController@index:authenticated',
                '/products/delete/[0-9]+' => 'ProductController@delete:authenticated',

                '/sales' => 'SaleController@index:authenticated',

                '/products/find/[0-9]+' => 'ProductController@findByBarcode:authenticated',
                '/sales/all' => 'SaleController@all:authenticated'
            ],
            'post' => [
                '/login/store' => 'LoginController@store',
                '/products/store' => 'ProductController@store:authenticated',
                '/products/update/[0-9]+' => 'ProductController@update:authenticated',
                '/sales/store' => 'SaleController@store:authenticated'
            ]
        ];
    }
}
