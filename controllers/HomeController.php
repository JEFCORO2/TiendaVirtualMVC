<?php
    
    namespace Controllers;
    use Model\Categoria;
    use MVC\Router;

    class HomeController {
        
        public static function listar(Router $router){
            $categorias = Categoria::listar();

            $router->mostrarVistas('index',[
                'categorias' => $categorias
            ]);
        }
    }

?>