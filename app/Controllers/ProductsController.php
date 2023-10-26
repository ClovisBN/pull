<?php 

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\ProductModel;

class ProductsController extends MainController 
{

    public function renderProducts(): void
    {
        $ProductModel = new ProductModel();
        $this->data = $ProductModel->getProduct();
        $this->render();
    }
}