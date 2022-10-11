<?php

namespace app\database\models;

use app\database\Connection;
use PDOException;

class Sale extends Model{
    protected $table = 'sales';


    /**
     * It inserts a new product into the sales_products table
     * 
     * @param array data
     * 
     * @return The result of the query execution.
     */
    public function addProduct(array $data)
    {
        try {
            $db = Connection::instance();
            $stmt = $db->prepare('INSERT INTO sales_products (sale_id, product_codebar, product_name, product_price, product_quantity, product_subtotal) VALUES (:sale_id, :product_codebar, :product_name, :product_price, :product_quantity, :product_subtotal)');
            return $stmt->execute($data);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function findResponsible(array $sales)
    {
        try {
            $db = Connection::instance();
            
            foreach ($sales as $index => $sale) {
                $userName  = $db->query("SELECT * FROM users WHERE id = {$sale->user_id}")->fetch();
                $sales[$index]->user_name = $userName->username;
            }

            return $sales;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

}