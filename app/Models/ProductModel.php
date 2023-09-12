<?php

namespace App\Models;
use App\Utility\DataBase;
use \PDO;

class ProductModel{

    private $id;
    private $name;
    private $size;
    private $color;
    private $categorie;
    private $price;
    
    
    public function getProduct($limit){
        
    $dbh = DataBase::connectPDO();

        if(!empty($limit)){
            $query = $dbh->prepare('SELECT * FROM pull LIMIT '.$limit);
        }else{
            $query = $dbh->prepare('SELECT * FROM pull');        
        }
        
        $query->execute();
        $pulls = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\ProductModel');
        return $pulls;
     
    }

    public function getProductById($id){
        
        $dbh = DataBase::connectPDO();
                                                                                                                                                                                                                                                                                            
        $query = $dbh->prepare('SELECT * FROM pull WHERE id=:id');
        $params = [
            'id'=>$id
        ];
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\ProductModel');
        $pull = $query->fetch();            
        return $pull;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of img
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of img
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of date
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of date
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get the value of title
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of title
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get the value of subtitle
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set the value of subtitle
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;    
        
    }

    /**
     * Get the value of content
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of content
     */
    public function setPrice($price)
    {
        $this->price = $price;    
        
    }
}