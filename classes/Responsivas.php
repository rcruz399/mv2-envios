<?php

namespace App;

class Responsivas extends ActiveRecord {
    //BASE DE DATOS

    protected static $tabla = 'responsivas';
    protected static $columnasDB = ['id', 'tag', 'oficina', 'devuser', 'fecha_entrega', 'estatus','usersis', 'responsiva'];
    public $id;
    public $tag;
    public $oficina;
    public $devuser;
    public $fecha_entrega;
    public $estatus;
    public $usersis;
    public $responsiva;

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
        $this->tag = $args['tag'] ?? '';
        $this->oficina = $args['oficina'] ?? '';
        $this->devuser = $args['devuser'] ?? '';
        $this->fecha_entrega = $args['fecha_entrega'] ?? '' ;
        $this->estatus = $args['estatus'] ?? '' ;
        $this->usersis = $args['usersis'] ?? '' ;
        $this->responsiva=$args['responsiva'] ?? 0;
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