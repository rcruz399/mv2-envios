<?php

namespace App;

class Articulos extends ActiveRecord {
    // Base DE DATOS
    protected static $tabla = 'stock_oficina';
    protected static $columnasDB = ['id', 'articulo', 'modelo', 'cantidad'];


    public $id;
    public $articulo;
    public $modelo;
    public $cantidad;
  

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->articulo = $args['articulo'] ??'';
        $this->modelo = $args['modelo'] ??'';
        $this->cantidad = $args['nombre'] ?? 0 ;


    }

    public function salida($id,$cantidad){
        $articulo = self::find($id);
        $newCant = intval($articulo->cantidad) - $cantidad;
        $articulo->cantidad = $newCant;
        return $articulo;
    }

    public function entrada($id,$cantidad){
        $articulo = self::find($id);
        $newCant = intval($articulo->cantidad) + $cantidad;
        $articulo->cantidad = $newCant;

        return $articulo;

    }
    
    public function validar($accion) {
        $articulo = self::find($this->id);
      
        
        if (!$articulo) {
            self::$errores[] = "Especifique un artículo";
        }
    
        if (!$this->cantidad || !is_numeric($this->cantidad) || intval($this->cantidad) <= 0) {
            
            self::$errores[] = "Introduzca una cantidad válida (número entero positivo y mayor que cero)";
        }
    
        // Aplicar validación de stock solo para salidas
        if ($accion === 'salida') {

            
            if (isset($articulo->cantidad) && intval($this->cantidad) > intval($articulo->cantidad)) {
                self::$errores[] = "La cantidad introducida es mayor al stock actual";
            }
            
        }
    
        return self::$errores;
    }


}