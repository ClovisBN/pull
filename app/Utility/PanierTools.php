<?php

namespace App\Utility;

class PanierTools {

    public static function addPanier(int $idProduct , int $qteProduct)
    {
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }

        if(array_key_exists($idProduct, $_SESSION['panier'])){
            $_SESSION['panier'][$idProduct] += $qteProduct;
        } else {
            $_SESSION['panier'][$idProduct] = $qteProduct;
        }
    }

    public static function decrementProductFromPanier($idProduct){
        if(array_key_exists($idProduct, $_SESSION['panier'])){
            $_SESSION['panier'][$idProduct] -= 1;
            return true;
        } else {
            return false;
        }
    }

    public static function incrementProductFromPanier($idProduct){
        if(array_key_exists($idProduct, $_SESSION['panier'])){
            $_SESSION['panier'][$idProduct] += 1;
            return true;
        } else {
            return false;
        }
    }
    public static function deleteProductFromPanier($idProduct)
    {   
        if(array_key_exists($idProduct, $_SESSION['panier'])){
            unset($_SESSION['panier'][$idProduct]);
            return true;
        } else {
            return false;
        }
    }

    public static function deletePanier(){
        if(isset($_SESSION['panier'])){
            unset($_SESSION['panier']);
            return true;
        }
        return false;
    }
}