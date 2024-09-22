<?php
    namespace Model;
    class Producto extends ActiveRecord { 
        protected static $tabla = 'productos';
        protected static $columnas = ['id', 'codigo', 'titulo', 'slug', 'descripcion', 'precio_normal', 'precio_rebajado', 'cantidad', 'imagen', 'archivo_zip', 'id_categoria'];

        public $codigo;
        public $titulo;
        public $slug;
        public $descripcion;
        public $precio_normal;
        public $precio_rebajado;
        public $cantidad;
        public $imagen;
        public $archivo_zip;
        public $id_categoria;

        public function __construct($arreglo=[])
        {
            $this->id = $arreglo['id'] ?? '';
            $this->codigo = $arreglo['codigo'] ?? '';
            $this->titulo = $arreglo['titulo'] ?? '';
            $this->slug = $arreglo['slug'] ?? '';
            $this->descripcion = $arreglo['descripcion'] ?? '';
            $this->precio_normal = $arreglo['precio_normal'] ?? '';
            $this->precio_rebajado = $arreglo['precio_rebajado'] ?? '';
            $this->cantidad = $arreglo['cantidad'] ?? '';
            $this->imagen = $arreglo['imagen'] ?? '';
            $this->archivo_zip = $arreglo['archivo_zip'] ?? '';
            $this->id_categoria = $arreglo['id_categoria'] ?? '';
        }
    }
?>