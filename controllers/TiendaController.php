<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Producto;
    use Model\Categoria;
    use Clases\Paginacion;

    class TiendaController {
        public static function listar(Router $router){

            $pagina_actual = $_GET['page'];

            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

            if(!$pagina_actual || $pagina_actual < 1) {
                header('Location: /tienda?page=1');
            }
            $registros_por_pagina = 6;
            $total = Producto::total();
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

            if($paginacion->total_paginas() < $pagina_actual) {
                header('Location: /tienda?page=1');
            }

            $productos = Producto::paginar($registros_por_pagina, $paginacion->offset());

            $categorias = Categoria::listar();
            //$productos = Producto::listar();

            $router->mostrarVistas('pruebas/shop',[
                'categorias' => $categorias,
                'productos' => $productos,
                'paginacion' => $paginacion->paginacion()
            ]);
        }

        public static function producto(Router $router){
            $router->mostrarVistas('pruebas/single');
        }
    }  
?>