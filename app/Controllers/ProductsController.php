<?php 

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\ProductModel;

class ProductsController extends MainController {

    public function renderProducts(){
        $ProductModel = new ProductModel();
        $this->data = $ProductModel->getProduct(10);
        $this->render();
    }


}

?>