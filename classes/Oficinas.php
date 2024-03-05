<?php

namespace App;

class Oficinas extends ActiveRecord {
    // Base DE DATOS
    protected static $tabla = 'oficinas';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;  

    public function __construct($args = [])
    {
        $this->id = $args['id']??'';
        $this->titulo = $args['nombre']??'';


    }
}