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
    private $img;
    
    
    public static function getProduct($limit=null){
        
    $dbh = DataBase::connectPDO();

        if(isset($limit)){
            $query = $dbh->prepare('SELECT * FROM pull LIMIT '.$limit . ' ORDER BY id DESC');
        }else{
            $query = $dbh->prepare('SELECT * FROM pull  ORDER BY id DESC');        
        }
        
        $query->execute();
        $pulls = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\ProductModel');
        return $pulls;
     
    }

    public static function getProductById($id){
        
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
    
    
    
        public function insertPull(): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO `pull`(`name`, `price`, `size`, `color`, `categorie`, `img`) VALUES (:name, :price, :size, :color, :categorie, :img)";
        $params = [
            'name' => $this->name,
            'price' => $this->price,
            'size' => $this->size,
            'color' => $this->color,
            'categorie' => $this->categorie,
            'img' => $this->img
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }


    public function updatePull(): bool
    {
        $pdo = DataBase::connectPDO();
        var_dump($this->id);
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'size' => $this->size,
            'color' => $this->color,
            'categorie' => $this->categorie,
        ];
         $sql = "UPDATE `pull` SET `name`= :name,`size`= :size,`color`= :color,`categorie`= :categorie,`price`= :price";
                
         if (isset($this->img)) {
            $params['img'] = $this->img;
             $sql .= ", `img` = :img";
        }
        $sql .= " WHERE `id` = :id";
        $query = $pdo->prepare($sql);
        
        $queryStatus = $query->execute($params);
        return $queryStatus;
        echo 'succes';
    }
    
    
    public static function deletePull(int $pullId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `pull` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $pullId, PDO::PARAM_INT);
        $queryStatus = $query->execute();
        return $queryStatus;
        echo 'succes';
    }

    public static function securImg($img)
    {

        if (isset($img)) {
        $target_dir = __DIR__."/../../public/assets/front/uploads/";
        $file_name = uniqid() . "." . pathinfo($img["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $file_name;
        $uploadok = 1;
        // Vérifiez si le fichier est une image
        
        
            $check = getimagesize($img["tmp_name"]);
        
            if ($check !== false) {
                echo "Le fichier est une image -" . $check["mime"] . ".";
                $uploadok = 1;
            
            } else {
                echo "Le fichier n'est pas une image.";
                $uploadok = 0;
            }
            
            
            
            // Vérifiez si le fichier existe déià
            if (file_exists($target_file)) {
                echo "Désolé, le fichier existe déjà.";
                $uploadok = 0;
            }
            
            // Vérifiez la taille du fichier
            if ($img["size"] > 200000) {
                echo "Désolé, le fichier est trop volumineux.";
                $uploadok = 0;
            }
            
            // Autorisez certaines extensions de fichier
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                
            if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
            ) {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                $uploadok = 0;
            }
            
            //1 vérifiez si suploadok est défini sur 0 par une erreur
            if ($uploadok == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
            
            // Si tout est correct, téléchargez le fichier
            } else {
 
                if (move_uploaded_file($img["tmp_name"], $target_file)) {
                echo "Le fichier " . $file_name ." a été téléchargé avec succès.";
                return $file_name;
                
                } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                }
            }
        
        }
    }


/**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     */
    public function setImg($img)
    {
        $this->img = $img;
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