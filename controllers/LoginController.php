<?php
    namespace Controllers;
    use MVC\Router;

    class LoginController {
        public static function login(Router $router){
            //echo "Desde login";
            $router->mostrarVistas('admin/login');
        }
    }
?>