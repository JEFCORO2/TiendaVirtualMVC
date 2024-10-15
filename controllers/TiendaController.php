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
            //validar que sea un entero y que no sea inyeccion sql
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

            if($id){
                $producto = Producto::where('id', $id);

                //listar productos por categorias
                $productosCategorias = Producto::listarCategoria($producto->id_categoria);

            }else {
                header('Location: /');
            }

            $router->mostrarVistas('pruebas/single', [
                'producto' => $producto,
                'productosCategoria' => $productosCategorias
            ]);
        }

        public static function recibirCarrito() {
            session_start(); // Asegúrate de que la sesión esté iniciada
        
            // Obtener los datos del carrito enviados desde JavaScript
            $datos = json_decode(file_get_contents('php://input'), true);
        
            if (isset($datos['carrito'])) {
                $_SESSION['carrito'] = $datos['carrito'];
        
                // Retornar una respuesta JSON para confirmar
                header('Content-Type: application/json'); // Asegúrate de establecer el tipo de contenido
                echo json_encode(['status' => 'success', 'message' => 'Carrito recibido', 'carrito' => $_SESSION['carrito']]);
            } else {
                header('Content-Type: application/json'); // Asegúrate de establecer el tipo de contenido
                echo json_encode(['status' => 'error', 'message' => 'No se recibió ningún carrito']);
            }
        }

        public static function deseo(Router $router){

            $router->mostrarVistas('pruebas/deseo');
        }

    }  
?>