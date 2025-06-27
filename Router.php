<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $funcion){
        $this->rutasGET[$url] = $funcion;
    }

    public function post($url, $funcion){
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas(){
        $urlActual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // ✅ más seguro
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET'){
            $funcion = $this->rutasGET[$urlActual] ?? null;
        } else {
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        if($funcion){
            call_user_func($funcion, $this);
        } else {
            echo "Página no encontrada...";
        }
    }

    //Muestra una vista
    public function mostrarVistas($vista, $datos = []) {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        // Incluir directamente la vista sin layout ni buffering
        $rutaVista = __DIR__ . "/views/$vista.php";

        if (file_exists($rutaVista)) {
            include $rutaVista;
        } else {
            echo "Vista '$vista' no encontrada.";
        }
    }
}

?>