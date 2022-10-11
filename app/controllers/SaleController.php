<?php

namespace app\controllers;

use app\core\Request;
use app\database\models\Sale;
use app\database\Pagination;

class SaleController extends Controller
{

    /**
     * It returns the view `restricted/sales/index`
     * 
     * @return The view file is being returned.
     */
    public function index()
    {
        return $this->view('restricted/sales/index', []);
    }


    /**
     * It receives the inputs from the form, creates a new sale, and then adds the products to the sale
     * 
     * @return the view of the sales page.
     */
    public function store()
    {
        $inputs = Request::all();


        $codes = $inputs['codes'];
        $products = $inputs['products'];
        $quantities = $inputs['quantities'];
        $prices = $inputs['prices'];
        $subtotals = $inputs['subtotals'];
        $totalPrice = brNumberToEn(removeMoneySimbol($inputs['total_price']));
        $devolution = brNumberToEn($inputs['client_payment']) - $totalPrice;
        $sale = new Sale;

        if ($saleId = $sale->create([
            'subtotal' => $totalPrice,
            'discount' => 0,
            'total' => $totalPrice,
            'user_id' => auth()->id
        ])) {
            $quantityProducts = count($codes);
            for ($i = 0; $i < $quantityProducts; $i++) {
                $codebar = $codes[$i];
                $productName  = $products[$i];
                $productQuantity  = brNumberToEn($quantities[$i]);
                $productPrice  = brNumberToEn(removeMoneySimbol($prices[$i]));
                $productSubtotal = brNumberToEn(removeMoneySimbol($subtotals[$i]));

                $sale->addProduct([
                    'sale_id' => $saleId,
                    'product_codebar' => $codebar,
                    'product_name' => $productName,
                    'product_price' => $productPrice,
                    'product_quantity' => $productQuantity,
                    'product_subtotal' => $productSubtotal
                ]);
            }

            setSession('devolution', numberBR($devolution));
            toastify('🔔 A venda foi realizada com sucesso', TOASTIFY_SUCCESS);
            return redirect(route('sales'));
        }
    }


    /**
     * It gets all sales, paginates them, and then returns the view
     * 
     * @return The view is being returned.
     */
    public function all()
    {
        $pagination = new Pagination;
        $pagination->setItemsPerPage(10);
        $sale = new Sale;
        $sale->setPagination($pagination);
        $allSales = $sale->all();
        $allSales = $sale->findResponsible($allSales);
        return $this->view('restricted/sales/all', [
            'sales' => $allSales,
            'pagination' => $pagination
        ]);
    }
}
