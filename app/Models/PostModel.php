<?php

namespace App\Models;
use App\Utility\DataBase;
use \PDO;

class PostModel{
    
    private $id;
    private $img;
    private $date;
    private $title;
    private $subtitle;
    private $content;
    
    
    public static function getPosts($limit=null){
        
    $dbh = DataBase::connectPDO();

        if(isset($limit)){
            $query = $dbh->prepare('SELECT * FROM post LIMIT '.$limit . ' ORDER BY id DESC');
        }else{
            $query = $dbh->prepare('SELECT * FROM post ORDER BY id DESC');        
        }
        
        $query->execute();
        $posts = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\PostModel');
        return $posts;
     
    }

    public static function getPostById($id){
        
        $dbh = DataBase::connectPDO();
                                                                                                                                                                                                                                                                                            
        $query = $dbh->prepare('SELECT * FROM post WHERE id=:id');
        $params = [
            'id'=>$id
        ];
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\PostModel');
        $post = $query->fetch();            
        return $post;
    }
    
    public function insertPost(): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO `post`(`title`, `content`, `subtitle`, `img`) VALUES (:title, :content, :subtitle, :img)";
        $params = [
            'title' => $this->title,
            'content' => $this->content,
            'subtitle' => $this->subtitle,
            'img' => $this->img
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }
    
    public function updatePost(): bool
    {
        $pdo = DataBase::connectPDO();
        var_dump($this->id);
        $params = [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'subtitle' => $this->subtitle,
        ];
         $sql = "UPDATE `post` SET `title` = :title, `content` = :content, `subtitle` = :subtitle";
        if (isset($this->img)) {
            $params['img'] = $this->img;
             $sql .= ", `img` = :img";
        }
        
        $sql .= " WHERE `id` = :id";
        $query = $pdo->prepare($sql);
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }
    
    public static function deletePost(int $postId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `post` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $postId, PDO::PARAM_INT);
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
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;    
        
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent($content)
    {
        $this->content = $content;    
        
    }
}

        function __construct() {
        var_dump($base_uri);
    }