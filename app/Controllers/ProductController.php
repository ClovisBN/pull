<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\ProductModel;

class ProductController extends MainController
{

    public function renderProduct(): void
    {
        $ProductModel = new ProductModel();        
        $this->data = $ProductModel->getProductById($this->subPage);   
        $this->render();
    }
}