<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Producto;
    use Model\Categoria;

    class TiendaController {
        public static function listar(Router $router){
            $categorias = Categoria::listar();
            $productos = Producto::listar();

            $router->mostrarVistas('pruebas/shop',[
                'categorias' => $categorias,
                'productos' => $productos
            ]);
        }
    }
    
?>