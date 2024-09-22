<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $errores = [];
    //protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database){
        return self::$db = $database;
    } 

    public static function setErrores($tipo, $mensaje) {
        static::$errores[$tipo][] = $mensaje;
    }

    public function guardar($idNombre){
        $resultado = '';
        $accion = $_POST['accion'] ?? '';
        
        if($accion === 'actualizar' || !is_null($this->$idNombre)){
            //actualizar
            $resultado = $this->actualizar($idNombre);
        }else{
            
            $resultado = $this->crear($idNombre);
        }

        return $resultado;
    }

    public function crear($idNombre){
        //sanitizar los datos

        $atributos = $this->sanitizarAtributos($idNombre);
        
        //echo "guardando en la base de datos";
        $query = "INSERT INTO " . static::$tabla . " ( ";         
        $query .= join(', ', array_keys($atributos));   // join : crea un unevo sstring  a partir de un arrreglo , lo va a apalnar y lo va acolocar todo en un string.
        $query .= " ) VALUES ('";                      // toma dos parametros , el pirmero es el separador, el mismo que ponemos en el query nomal, y el segunso es que arrreglo vamso a aplanar
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        
        $resultado = self :: $db -> query($query);

        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
         ];
    }

    public function actualizar($idNombre){
        $atributos = $this->sanitizarAtributos($idNombre);
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE $idNombre = '" . self::$db->escape_string($this->$idNombre). "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public static function buscar($id,$nombreId){
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE $nombreId = $id";  //cuidado aca deveria ser con llaves en el id
        //cambiarFormato($consulta);
        $resultado =  self::consultarSQL($consulta);
        return array_shift($resultado); // debuelve el arreglo de objetos, pero la primera posicion
    }

    public static function where($columna, $valor){
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";  //cuidado aca deveria ser con llaves en el id
        //cambiarFormato($consulta);
        $resultado =  self::consultarSQL($consulta);
        return array_shift($resultado); // debuelve el arreglo de objetos, pero la primera posicion
    }


    //en el buscra 2 esta tratanbd el id como una cadena, mas no como un int

    public static function buscar2($id, $nombreId){
        $id = self::$db->escape_string($id);  // Sanitizar el valor
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE $nombreId = '$id'";
        $resultado = self::consultarSQL($consulta);
        return array_shift($resultado);
    }

    public function eliminar($nombreId){
        //Elimina la propiedad
        //$query = "DELETE FROM " . static::$tabla . " WHERE $nombreId = " . self::$db->escape_string($this->$nombreId) . " LIMIT 1";  esta es para numero enteros, pero el codAlumno es una cadena
        $query = "DELETE FROM " . static::$tabla . " WHERE $nombreId = '" . self::$db->escape_string($this->$nombreId) . "' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function sanitizarAtributos($idNombre){
        $atributos = $this->atributos($idNombre);
        $sanitizado = [];

        foreach($atributos as $key => $value){  // sintaxis de una arreglo asociativo, es como si fuera una coleccion de objetos
            $sanitizado[$key] = self :: $db->escape_string($value);
        }
        return $sanitizado;
    }
    
    public function atributos($idNombre){ // esta funcion solo sirve para mapear datos, solo es para presentacion
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($this instanceof Usuario){
                if($columna===$idNombre) continue;
            }
            $atributos[$columna] = $this->$columna;  //porque aca si con signo dolar, porque aca la columna es una variable del foreach
        }
        //cambiarFormato($atributos);
        return $atributos;
    }

    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public static function listar(){     //creamos listar OBJETOS
        $query = "SELECT * FROM " . static::$tabla;  // el static -> hereda este metodo, y va a buscar este atributo en la clase cual se esta heredando, cual pueda ser propiedad o vendedores

        $resultado = self :: consultarSQL($query);  //FORMATEA TODO COMO OBJETOS MAS NO COMO ARREGLOS

        return $resultado; //DEVUELVE UN ARREGLO DE OBJETOS
        //cambiarFormato($resultado);
    }

    public static function consultarSQL($query){
        //CONSULTAR LA BASE DE DATOS
        $resultado = self::$db->query($query);

        $array = [];
        //ITERAR LOS RESULTADOS
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        } 
        //LIBERRAR LA MEMORIA
        $resultado->free();

        //RETORNAR LOS RESULTADOS
        return $array;
    }

    public static function crearObjeto($registro){
        $objeto = new static; // es como si fuera new Propiedad

        foreach($registro as $key => $value){
            if(property_exists( $objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    public function sincronizar($arreglo=[]){
        foreach($arreglo as $key => $value ){  //porque es un arreglo asociativo
            if(property_exists($this,$key) && !is_null($value)){
                $this->$key = $value;
            }
        }   
    }
}