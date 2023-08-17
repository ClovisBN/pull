<?php

require __DIR__.'/vendor/autoload.php';


const AVAIABLE_ROUTES = [
    'home'=>[
        'action' => 'renderHome',
        'controller' => 'HomeController'
    ],
    'products'=>[
        'action' => 'render',
        'controller' => 'ProductsController'
    ],
    'contact'=>[
        'action' => 'render',
        'controller' => 'ContactController'
    ],
    '404'=>[
        'action' => 'render',
        'controller' => 'ErrorController'
    ],
];

// initiatilisation des variables
$page = 'home';
$controller;
$itemId = null;
// s'il y a un param GET page, on le stock dans la var page sinon on redirige vers home
if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = $_GET['page'];
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
$pageController->$controllerAction();

?>

