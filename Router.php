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
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET'){
            $funcion = $this->rutasGET[$urlActual] ?? null;
        }else{
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        if($funcion){
            //La URL existe y hay una funcion asociada
            call_user_func($funcion, $this); //->sirve para llamar una funcion cuando no sabemos el nombre de la funcion
        }else {
            echo "Pagina no encontrada....";
        }
    }

    //Muestra una vista
    public function mostrarVistas($vista, $datos = []){

        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start();  //alamacena un almacenamiento en memoria , todo lo siguiente de esta linea lo va a guardar
        
        include __DIR__ . "/views/$vista.php";

        //$contenido = ob_get_clean();

        //include __DIR__ . "/views/layout.php";
    }
}

?>