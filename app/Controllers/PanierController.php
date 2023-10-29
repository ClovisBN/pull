<?php

namespace App\Controllers;
use App\Models\ProductModel;

use App\Controllers\MainController;
use App\Utility\PanierTools;

class PanierController extends MainController
{

    public function renderPanier(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['addProduct'])) {
                $this->addMethode();
            } else if((isset($_POST['deleteProduct']))){
                $this->deleteMethode();
            } else if((isset($_POST['decrementProduct']))){
                $this->decrementMethode();
            } else if((isset($_POST['incrementProduct']))){
                $this->incrementMethode();
            } else if((isset($_POST['payement']))){
                $this->paiementMethode();
            }
        }


        // 
        $ProductModel = new ProductModel();
        //$this->data = $ProductModel->getProductById();
        $this->render();
    }
    
    function addMethode()
    {
        $idProduct = filter_input(INPUT_POST, 'idProduct');
        $qteProduct = filter_input(INPUT_POST, 'qteProduct');
    
        PanierTools::addPanier($idProduct, $qteProduct);
    }

    function deleteMethode(){
        $idProduct = filter_input(INPUT_POST, 'idProduct');
    
        if(PanierTools::deleteProductFromPanier($idProduct)){
            echo 'Article effacer du panier';
        } else {
            echo 'Probleme lors de la suppression de l\'article';
        }
    }

    function decrementMethode() {
        $idProduct = filter_input(INPUT_POST, 'idProduct');
    
        if(PanierTools::decrementProductFromPanier($idProduct)){
            echo '1 article supprimer du panier';
        } else {
            echo 'Probleme lors de la mise à jour de l\'article';
        }
    }

    function incrementMethode() {
        $idProduct = filter_input(INPUT_POST, 'idProduct');
    
        if(PanierTools::incrementProductFromPanier($idProduct)){
            echo '1 article ajouter au panier';
        } else {
            echo 'Probleme lors de la mise à jour de l\'article';
        }
    }

    function paiementMethode(){
        if(PanierTools::deletePanier()){
            'Paiements Effectués. Merci de votre achat';
        } else {
            'Une erreur s\'est produit lors de l\'affichage du panier';
        }
    }
}