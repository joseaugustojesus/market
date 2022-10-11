<?php

namespace app\controllers;

use app\core\Request;
use app\database\Filters;
use app\database\models\Product;
use app\database\Pagination;
use app\support\Validate;

class ProductController extends Controller
{

    /**
     * It returns the view `restricted/products/index`
     * 
     * @return The view file is being returned.
     */
    public function index()
    {
        $pagination = new Pagination;
        $pagination->setItemsPerPage(8);
        $product = new Product;
        $product->setPagination($pagination);
        $products = $product->all();
        return $this->view('restricted/products/index', [
            'products' => $products,
            'pagination' => $pagination
        ]);
    }




    /**
     * It validates the data, if it's valid, it creates a new product, if it's not, it redirects the
     * user to the products page
     * 
     * @return the redirect to the route products.
     */
    public function store()
    {
        $validate = new Validate;
        $data = $validate->validate([
            'code' => 'required',
            'name' => 'required',
            'inventory' => 'required|number',
            'unit' => 'required',
            'price' => 'required|number',
        ]);

        if (!$validate->validated($data)) {
            toastify('🔔 Verifique os campos antes de prosseguir ', TOASTIFY_DANGER);
            return redirect(route('products'));
        }

        $product = new Product;
        if ($product->create($data))
            toastify('🔔 O produto foi adicionado com sucesso', TOASTIFY_SUCCESS);
        else
            toastify('🔔 Houve um erro ao tentar cadastrar o produto', TOASTIFY_DANGER);

        return redirect(route('products'));
    }



    /**
     * It updates a product in the database
     * 
     * @param int productCode The product code to be updated.
     * 
     * @return the redirect to the route products.
     */
    public function update(int $productCode)
    {
        $product = new Product;

        if (!$product->findByOne('code', '=', $productCode)) {
            toastify('🔔 Houve um erro ao tentar atualizar o registro', TOASTIFY_DANGER);
            return redirect(route('products'));
        }

        $validate = new Validate;
        $data = $validate->validate([
            'code' => 'required',
            'name' => 'required',
            'inventory' => 'required|number',
            'unit' => 'required',
            'price' => 'required|number',
        ]);

        if (!$validate->validated($data)) {
            setSession('validateUpdate', 1);
            toastify('🔔 Verifique os campos antes de prosseguir', TOASTIFY_DANGER);
            return redirect(route('products'));
        }

        if (!$product->update('code', $productCode, $data)) toastify('🔔 Verifique os campos antes de prosseguir', TOASTIFY_DANGER);
        else toastify('🔔 O produto foi atualizado com sucesso', TOASTIFY_SUCCESS);

        return redirect(route('products'));
    }



    /**
     * It deletes a product from the database
     * 
     * @param int productCode The product code to be deleted
     * 
     * @return The product is being deleted from the database and the user is being redirected to the
     * products page.
     */
    public function delete(int $productCode)
    {
        $product = new Product;
        $product->delete('code', $productCode);

        toastify('🔔 O produto foi deletado com sucesso', TOASTIFY_SUCCESS);
        return redirect(route('products'));
    }


    /**
     * It receives a barcode, searches for a product with that barcode, and returns a response with the
     * product or an error message
     * 
     * @param int barcode The product's barcode
     * 
     * @return The product found by the barcode
     */
    public function findByBarcode(int $barcode)
    {

        if (!$barcode) return response_json(['message' => '🔔 O código de barra é obrigatório', 'status' => 300]);
        $product = (new Product)->findByOne('code', '=', $barcode);
        if (!$product) return response_json(['message' => '🔔 O produto não pôde ser encontrado', 'status' => 400]);

        $product->price = numberBR($product->price);
        return response_json([
            'message' => '🔔 O produto foi encontrado com sucesso',
            'status' => 200,
            'product' => $product
        ]);
    }
}
