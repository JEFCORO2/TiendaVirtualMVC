<?php
namespace Model;
class Categoria extends ActiveRecord {

    protected static $tabla = 'categorias';
    protected static $columnas = ['id', 'nombre', 'slug', 'imagen'];

    public $id;
    public $nombre;
    public $slug;
    public $imagen;

    public function __construct($arreglo=[])
    {
        $this->id = $arreglo['id'] ?? '';
        $this->codigo = $arreglo['nombre'] ?? '';
        $this->titulo = $arreglo['slug'] ?? '';
        $this->slug = $arreglo['imagen'] ?? '';
    }

}
