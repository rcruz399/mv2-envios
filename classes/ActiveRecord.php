<?php

namespace App;

class ActiveRecord {
     // Base DE DATOS
     protected static $db;
     protected static $tabla = '';
     protected static $columnasDB = [];
     protected static $ldap_dn ='';
     protected static $filtro ="";
     protected static $attributes =[];
 
     // Errores
     protected static $errores = [];
 
     
     // Definir la conexión a la BD
     public static function setDB($database) {
         self::$db = $database;
     }

     public static function setDBocs($database) {
        self::$db = $database;
    }

     //Definir la conexion al LDAP
     public static function setLDAP($dn) {
        self::$ldap_dn = $dn;
    }

     
    // Validación
    public static function getErrores() {
        return static::$errores;
    }
    
    public function validar($accion) {
        static::$errores = [];
        return static::$errores;
    }

    // Registros - CRUD
    public function guardar() {
        if(!is_null($this->id)) {
            // actualizar
            $this->actualizar();
        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function guardarLDAP($action,$what) {
        
        if($action === "actualizar") {
            // actualizar
            $this->actualizarLDAP();
        } else {
            // Creando un nuevo registro
            
            $this->crearLDAP($what);
        }
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    //busca todos los objetos de LDAP
    public static function allLDAP(){

        $ldapconn = conectarLDAP();
        $filter = static::$filtro;
        $basedn= static::$dn;   
        $result = ldap_search($ldapconn, $basedn, $filter);
        $entries = ldap_get_entries($ldapconn, $result);
        $attributes = static::$ldapAttributes;
        $objects = [];
        for ($i = 1; $i < $entries['count']; $i++) {
            $entryData = [];
            foreach ($attributes as $attribute) {
                $entryData[$attribute] = isset($entries[$i][$attribute][0]) ? $entries[$i][$attribute][0] : "sindefinir";
            }
    
            $objects[] = new static($entryData);
        }
    
        ldap_close($ldapconn);
    
        return $objects;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado ) ;
    }

    public static function findLDAP($parametro,$valor) {
        
        $ldapconn = conectarLDAP();
        $filter = "(".$parametro."=".$valor.")";
       
        $basedn= static::$dn; 
        
       
        $result = ldap_search($ldapconn, $basedn, $filter);
        $entries = ldap_get_entries($ldapconn, $result);    
        $attributes = static::$ldapAttributes;
        $resultado ="sindefinir";
        if ($valor !== 'sindefinir') {
            for ($i = 0; $i < $entries['count']; $i++) {
                $entryData = [];
                foreach ($attributes as $attribute) {
                    $entryData[$attribute] = isset($entries[$i][$attribute][0]) ? $entries[$i][$attribute][0] : "sindefinir";
                }
    
                $resultado = self::crearObjeto($entryData);
            }
        }
    
        ldap_close($ldapconn);
        
        return $resultado;
    }

    
    public static function findocs($name) {

        $query = "SELECT
                        h.ID,
                        h.deviceid,
                        h.name,
                        h.osname,
                        h.winprodkey,
                        h.archive,
                        b.hardware_id,
                        b.smanufacturer,
                        b.smodel,
                        b.ssn,
                        b.type
                    FROM
                        hardware h
                    JOIN
                        bios b ON h.ID = b.hardware_id
                    WHERE
                        h.name = '${name}';";
        $resultado = self::consultarSQL($query);

        return array_shift( $resultado );
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);

        // Mensaje de exito
        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /mv2/index.php');
        }
    }

    public function crearLDAP($what){
        $ldapconn = conectarLDAP();
        //pasamos del objeto a un array para ldap
        $entry= get_object_vars($this);
       // debuguear($entry);
        //verificar si es movil o devuser
        if ($what === "movil"){
            $dn ="devicetag=".$this->devicetag.",ou=Celulares,ou=Devices,dc=transportespitic,dc=com";
            $entry['objectClass'][0] = "top";
            $entry['objectClass'][1] = "DeviceInfo";
        }elseif ($what ==="devuser"){
            $dn ="duusernname=".$this->dunombre.",ou=DeviceUsers,dc=transportespitic,dc=com";
            $entry['objectClass'][0] = "deviceuser";
        }

        
        if (ldap_add($ldapconn, $dn, $entry)) {
            echo 'Celular agregado con éxito.';
        } else {
            echo 'Error al agregar el objeto DeviceUser: ' . ldap_error($ldapconn);
        }
        

    }

    public function actualizar() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";

        $query .= " LIMIT 1 "; 
        
        $resultado = self::$db->query($query);
        if($resultado) {
            echo '<script>window.location.href = "/mv2/index.php?page=stock_bodega";</script>';

            
        }
    
    }

    public static function actualizarLDAP($entry){
        var_dump ($entry);
    }

    // Eliminar un registro
    public function eliminar() {
        // Eliminar el registro
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        
        foreach($registro as $key => $value ) {
           
                $objeto->$key = $value;
            
        }
        
        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args=[]) { 
        
        foreach($args as $key => $value) {
           
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
            
          }
        }
    }


    public static function apirrhh($clave, $returnArray = false) {
        $url = 'https://www.transportespitic.com.mx/light/empleados/info';
        $data = array(
            'clave_busca' => $clave
        );
    
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc3VhcmlvIjoicGl0aWMiLCJpYXQiOjE2NjczMzQ4ODEsImV4cCI6MTY2OTkyNjg4MX0';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    
        // Imprimir la respuesta para depuración
        //echo "Respuesta de la API:\n";
        //debuguear($response);
    
        curl_close($ch);
    
        if ($returnArray) {
            // Devolver el array de la respuesta sin procesar
            return json_decode($response, true);
        } else {
            // Procesar la respuesta y devolver si está activo o no
            $data = json_decode($response, true);
    
            $activo = "";
    
            if (isset($data["info"][0]["fechabaja"]) && $data["info"][0]["fechabaja"] !== null) {
                $activo = "NO";
            } elseif (isset($data["Data"]) && $data["Data"] === "Error") {
                $activo = "";
            } else {
                $activo = "SI";
            }
    
            return $activo;
        }
    }
}
 
