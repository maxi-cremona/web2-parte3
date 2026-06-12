<?php
    require_once './config.php';
    require_once './libs/router/router.php';
    require_once './libs/jwt/jwt_middleware.php';
    require_once './app/controllers/auth_api_controller.php';
    require_once './app/controllers/noticia_api_controller.php';
    require_once './app/middlewares/guard_api_middleware.php';


    $router = new Router();

    $router->addRoute('auth/login', 'POST', 'AuthApiController', 'login');
    
    $router->addMiddleware(new JWTMiddleware());

    #                 endpoint        verbo            controller              metodo
    #GET
    $router->addRoute('','','','');
    $router->addRoute('noticias/:id','GET','NoticiaApiController','getNoticiaByID');
    
    $router->addMiddleware(new GuardMiddleware());

    #POST
    $router->addRoute('noticias','POST','NoticiaApiController','addNoticia');

    #PUT
    $router->addRoute('','','','');

    #DELETE
    $router->addRoute('noticias/:id','DELETE','NoticiaApiController','deleteNoticia');


    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>