<?php

namespace App;

class ResponsivasEquipos extends ActiveRecord {
    //BASE DE DATOS

    protected static $tabla = 'responsivasEquipos';
    protected static $columnasDB = ['id','oficina','usuario' ,'tipo', 'marca', 'modelo', 'serie', 'estatus','garantia', 'factura','responsiva'];
    public $id;
    public $oficina;
    public $usuario;
    public $tipo;
    public $marca;
    public $modelo;
    public $serie;
    public $estatus;
    public $garantia;
    public $factura;

    // LDAP
    //protected static $dn = "ou=Celulares,ou=Devices,dc=transportespitic,dc=com";
   // protected static $filtro = "(&(devicetag=*)(!(deviceassignedto=BAJA))(!(deviceoffice=BAJA*)))";
   // protected static $ldapAttributes = [
   //     'devicetag',
   //     'deviceassignedto',
   //     'devicebrand',
   //     'devicedept',
   //     'deviceimei',
   //     'devicemodel',
  //      'devicenumber',
  //      'deviceoffice',
  //      'deviceserial'
  //  ];
    
  

    public function __construct($args = []){
        //foreach (static::$ldapAttributes as $attribute) {
        //    $this->$attribute = $args[$attribute] ?? "sindefinir";
       // }

        $this->id = $args['id'] ?? '';
        $this->oficina = $args['oficina'] ?? '';
        $this->usuario = $args['usuario'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->marca = $args['marca'] ?? '';
        $this->modelo = $args['modelo'] ?? '';
        $this->serie = $args['serie'] ?? '';
        $this->estatus = $args['estatus'] ?? '';
        $this->garantia = $args['garantia'] ?? '';
        $this->factura = $args['factura'] ?? '';



    }

   /* public function validar() {
        if (!$this->tag) {
            self::$errores[]= "Debes de añadir tag";
        }else{
            $atributo = $this->findLDAP('devicetag',$this->tag);
            debuguear($atributo);
        }
        if (!$this->oficina) {
            self::$errores[]= "Debes de añadir una oficina";
        }
        if (!$this->devuser) {
            self::$errores[]= "Debes de añadir undevuser";
        }
        if (!$this->fecha_entrega) {
            self::$errores[]= "Debes de añadir una fecha";
        }
        if (!$this->estatus) {
            self::$errores[]= "Debes de definir un estatus 'entregado' o 'enviado'";
        }
        if (!$this->responsiva) {
            self::$errores[]= "Debes de añadir un archivo";
        }
    }*/

 //Subida de archivos

 public  function setResponsiva ($responsiva){
    //Elimina PDF previo
    if(!is_null($this->id)){
        $this->borrarResponsiva();
    }
    //Asigna el atributo al nombre
    if($responsiva) {
        $this->responsiva = $responsiva;
    }
}

    // Elimina el archivo
    public function borrarResponsiva() {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_RESPONSIVAS . $this->responsiva);
        if($existeArchivo) {
            unlink(CARPETA_RESPONSIVAS . $this->responsiva);
        }
    }
}