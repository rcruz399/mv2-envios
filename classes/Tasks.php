<?php

namespace App;

class Tasks extends ActiveRecord {
    // Base DE DATOS
    protected static $tabla = 'tasks';
    protected static $columnasDB = ['id', 'titulo', 'contenido', 'autor', 'estado', 'fecha_registro', 'fecha_actualizado'];


    public $id;
    public $titulo;
    public $contenido;
    public $autor;
    public $estado;
    public $fecha_registro;
    public $fecha_actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->autor = $args['autor'] ?? '';
        $this->estado = $args['estado'] ?? 1;
        $this->fecha_registro = $args['fecha_registro'] ?? null;
        $this->fecha_actualizado = $args['fecha_actualizado'] ?? null;

    }

    
    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->contenido) {
            self::$errores[] = 'El contenido es Obligatorio';
        }

        if( strlen( $this->contenido ) < 3 ) {
            self::$errores[] = 'El contenido debe de tener al menos 3 caracteres';
        }
        
        return self::$errores;
    }
}