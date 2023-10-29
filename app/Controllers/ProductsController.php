<?php 

namespace App\Controllers;
use App\Models\ProductModel;

use App\Controllers\MainController;

class ProductsController extends MainController 
{

    public function renderProducts(): void
    {
        $ProductModel = new ProductModel();
        $this->data = $ProductModel->getProduct();
        $this->render();
    }
}