<?php

namespace app\controllers;

use app\database\Filters;
use app\database\models\Product;

class DashboardController extends Controller
{
    
    /**
     * We're creating a new instance of the `Filters` class, setting the order by and limit, then
     * creating a new instance of the `Product` class, setting the filters, and finally getting all the
     * products
     * 
     * @return The view file 'restricted/dashboard' is being returned.
     */
    public function index()
    {
        $filters = new Filters;
        $filters->orderBy('inventory', 'ASC');
        $filters->limit(5);
        $product = new Product;
        $product->setFilters($filters);
        $products = $product->all();



        return $this->view('restricted/dashboard', [
            'products' => $products
        ]);
    }
}
