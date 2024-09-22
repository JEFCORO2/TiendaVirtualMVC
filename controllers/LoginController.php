<?php
    namespace Controllers;
    use MVC\Router;

    class LoginController {
        public static function login(Router $router){
            //echo "Desde login";
            $router->mostrarVistas('index');
        }

        public static function about(Router $router){
            //echo "Desde login";
            $router->mostrarVistas('pruebas/about');
        }

        public static function tienda(Router $router){
            //echo "Desde login";
            $router->mostrarVistas('pruebas/shop');
        }
    }
?>