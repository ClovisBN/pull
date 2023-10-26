<?php

require __DIR__ . '/../vendor/autoload.php';

$base_uri = $_SERVER['REQUEST_URI'];
require __DIR__ . "/../app/Utility/Constant/constant.php";
session_start();

const AVAIABLE_ROUTES = [
    'home'=>[
        'action' => 'renderHome',
        'controller' => 'HomeController'
    ],
    'products'=>[
        'action' => 'renderProducts',
        'controller' => 'ProductsController'
    ],
    'contact'=>[
        'action' => 'renderContact',
        'controller' => 'ContactController'
    ],
    'profile'=>[
        'action' => 'renderProfile',
        'controller' => 'ProfileController'
    ],
    'post'=>[
        'action' => 'renderPost',
        'controller' => 'PostController'
    ],
    'product'=>[
        'action' => 'renderProduct',
        'controller' => 'ProductController'
    ],
    'login'=>[
        'action' => 'renderUser',
        'controller' => 'UserController'
    ],
    'register'=>[
        'action' => 'renderUser',
        'controller' => 'UserController'
    ],
    'admin'=>[
        'action' => 'renderAdmin',
        'controller' => 'AdminController'
    ],
    'addPost'=>[
        'action' => 'renderAdmin',
        'controller' => 'AdminController'
    ],
    'addProduct'=>[
        'action' => 'renderAdmin',
        'controller' => 'AdminController'
    ],
    'logout'=>[
        'action' => 'renderUser',
        'controller' => 'UserController'
    ],
    '404'=>[
        'action' => 'render',
        'controller' => 'ErrorController'
    ],
];

// initiatilisation des variables
$page = 'home';
$controller;
$subPage = null;

// s'il y a un param GET page, on le stock dans la var page sinon on redirige vers home
if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = $_GET['page'];
    if(!empty($_GET['subpage'])){
        $subPage = $_GET['subpage'];        
    }
}else{
    $page = 'home';    
}

// Si la page demandée fait partie de notre tableau de routes, on la stocke dans la variable controller
// sinon on redirige vers le controller ErrorController
if(array_key_exists($page,AVAIABLE_ROUTES)){
    $controller = AVAIABLE_ROUTES[$page]['controller'];
    $controllerAction = AVAIABLE_ROUTES[$page]['action'];
}else{
    $controller = 'ErrorController';
}

$namespace = 'App\Controllers';
$controllerClassName = $namespace . '\\' . $controller;

$pageController = new $controllerClassName();
$pageController->setView($page);
$pageController->setSubPage($subPage);
$pageController->$controllerAction();

?>

