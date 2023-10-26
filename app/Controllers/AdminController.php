<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\PostModel;
use App\Models\ProductModel;

class AdminController extends MainController
{
    public function renderAdmin(): void
    {
        $this->checkUserAuthorization(1);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            if (isset($_POST["addPostForm"])) {
                $this->addPost();
            }
            if (isset($_POST['deletePostForm'])) {
                $this->removePost();
            }
            if (isset($_POST['updatePostForm'])) {
                $this->updatePost();
            }
            
            
            if (isset($_POST["addPullForm"])) {
                $this->addPull();
            }
            if (isset($_POST['deletePullForm'])) {
                $this->removePull();
            }
            if (isset($_POST['updatePullForm'])) {
                $this->updatePull();
            }
        }


        $this->viewType = 'admin';


        if (isset($this->subPage)) {
            $this->view = $this->subPage;
            if ($this->view === 'updatePost') {
                if (isset($_GET['id'])) {
                    $post = PostModel::getPostById($_GET['id']);
                    if (is_null($post)) {
                        $this->data['error'] = '<div>L\'article n\'existe pas</div>';
                    } else {
                        $this->data['post'] = $post;
                    }
                }
            }
        } else {
            // Sinon s'il n'ya pas de sous-page, on stocke dans la propriété data tous les articles pour les afficher dans la vue admin            
            $this->data['posts'] = PostModel::getPosts();
        }
    

    
        if (isset($this->subPage)) {
            $this->view = $this->subPage;
            if ($this->view === 'updateProduct') {
                if (isset($_GET['id'])) {
                    $pulls = ProductModel::getProductById($_GET['id']);
                    if (is_null($pulls)) {
                        $this->data['error'] = '<div>L\'article n\'existe pas</div>';
                    } else {
                        $this->data['pulls'] = $pulls;
                    }
                }
            }
        } else {
            // Sinon s'il n'ya pas de sous-page, on stocke dans la propriété data tous les articles pour les afficher dans la vue admin            
            $this->data['pulls'] = ProductModel::getProduct();
        }
        
        //  dans tous les cas on appelle la méthode render du controller parent pour construire la page
        $this->render();
    }






    public function addPost(): void
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $img  = $_FILES['img'];
        
        $postModel = new PostModel();
        $postModel->setTitle($title);
        $postModel->setContent($content);
        $postModel->setSubtitle($subtitle);
            
        if($img['size'] > 0){
            $imgName = $postModel->securImg($img); 
            $postModel->setImg($imgName);
        }

        $postModel->insertPost();
    }
    
    public function updatePost(): void
    {

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $img  = $_FILES['img'];
            
        $postModel = new PostModel();
        $postModel->setId($id);
        $postModel->setTitle($title);
        $postModel->setContent($content);
        $postModel->setSubtitle($subtitle);
            
            
        if($img['size'] > 0){
            $imgName = $postModel->securImg($img); 
            $postModel->setImg($imgName);
        }
        
        $postModel->updatePost();
    }
    
    public function removePost(): void
    {
        $postId = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_SPECIAL_CHARS);

        if (PostModel::deletePost($postId)) {
            $this->data['infos'] = '<div> Article supprimé avec succès </div>';
        } else {
            $this->data['infos'] = '<div> Il s\'est produit une erreur </div>';
        }
    }
    
    
    
    
    
    
    
    
    public function addPull(): void
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
        $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_SPECIAL_CHARS);
        $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_SPECIAL_CHARS);
        $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
        $img  = $_FILES['img'];
        
        $pullModel = new ProductModel();
        $pullModel->setName($name);
        $pullModel->setPrice($price);
        $pullModel->setSize($size);
        $pullModel->setColor($color);
        $pullModel->setCategorie($categorie);
            
        if($img['size'] > 0){
            $imgName = $pullModel->securImg($img); 
            $pullModel->setImg($imgName);
        }

        $pullModel->insertPull();
    }



        public function updatePull(): void
    {

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
        $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_SPECIAL_CHARS);
        $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_SPECIAL_CHARS);
        $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $img  = $_FILES['img'];
            
        $pullModel = new ProductModel();
        $pullModel->setId($id);
        $pullModel->setName($name);
        $pullModel->setPrice($price);
        $pullModel->setSize($size);
        $pullModel->setColor($color);
        $pullModel->setCategorie($categorie);
            
            
        if($img['size'] > 0){
            $imgName = $pullModel->securImg($img); 
            $pullModel->setImg($imgName);
        }
            
        $pullModel->updatePull();
    }



        public function removePull(): void
    {
        $pullId = filter_input(INPUT_POST, 'pullid', FILTER_SANITIZE_SPECIAL_CHARS);

        if (ProductModel::deletePull($pullId)) {
            $this->data['infos'] = '<div> Le produit est supprimé avec succès </div>';
        } else {
            $this->data['infos'] = '<div> Il s\'est produit une erreur </div>';
        }
    }
}