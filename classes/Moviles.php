<?php
    namespace App;

    class Moviles extends ActiveRecord {
        // Definir propiedades de la clase de manera explícita
        public $devicetag = "PORASIGNAR";
        public $deviceassignedto = "PORASIGNAR";
        public $devicebrand = "PORASIGNAR";
        public $devicedept = "PORASIGNAR";
        public $deviceimei = "PORASIGNAR";
        public $devicemodel = "PORASIGNAR";
        public $devicenumber = "PORASIGNAR";
        public $deviceoffice = "PORASIGNAR";
        public $deviceserial = "PORASIGNAR";

        // Base de datos LDAP
        protected static $dn = "ou=Celulares,ou=Devices,dc=transportespitic,dc=com";
        protected static $filtro = "(&(devicetag=*)(!(deviceassignedto=BAJA))(!(deviceoffice=BAJA*)))";
        protected static $ldapAttributes = [
            'devicetag',
            'deviceassignedto',
            'devicebrand',
            'devicedept',
            'deviceimei',
            'devicemodel',
            'devicenumber',
            'deviceoffice',
            'deviceserial'
        ];

        public function __construct($args = []){
            // Asignar valores a las propiedades desde el constructor
            $this->devicetag = $args['devicetag'] ?? "PORASIGNAR";
            $this->deviceassignedto = $args['deviceassignedto'] ?? "PORASIGNAR";
            $this->devicebrand = $args['devicebrand'] ?? "PORASIGNAR";
            $this->devicedept = $args['devicedept'] ?? "PORASIGNAR";
            $this->deviceimei = $args['deviceimei'] ?? "PORASIGNAR";
            $this->devicemodel = $args['devicemodel'] ?? "PORASIGNAR";
            $this->devicenumber = $args['devicenumber'] ?? "PORASIGNAR";
            $this->deviceoffice = $args['deviceoffice'] ?? "PORASIGNAR";
            $this->deviceserial = $args['deviceserial'] ?? "PORASIGNAR";
        }

        public static function findMovilByTag($tag) {
            // Realizar la búsqueda en LDAP
            $result = ldap_buscar(self::$dn, "(devicetag=$tag)");

            // Verificar si se encontraron resultados
            if ($result && ldap_count_entries(self::$ldap, $result) == 1) {
                $entry = ldap_get_entries(self::$ldap, $result);
                return new Moviles($entry[0]);
            } else {
                return null;
            }
        }

        public function geeterrores() {
            if(!$this->devicetag) {
                self::$errores[] = "Debes añadir un tag";
            }
            return self::$errores;
        }
    }
?>