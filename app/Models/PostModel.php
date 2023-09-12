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

        if(!empty($limit)){
            $query = $dbh->prepare('SELECT * FROM post LIMIT '.$limit);
        }else{
            $query = $dbh->prepare('SELECT * FROM post');        
        }
        
        $query->execute();
        $posts = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\PostModel');
        return $posts;
     
    }

    public function getPostById($id){
        
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