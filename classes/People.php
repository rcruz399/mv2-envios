<?php

namespace App;

class People extends ActiveRecord {
    // Base DE DATOS
    protected static $dn = "ou=People,dc=transportespitic,dc=com";
    protected static $filtro = "(uid=*)";
    protected static $ldapAttributes = [
        'uid',
        'cn',
        'givenName',
        'sn',
        'noempleado'
        
        
    ];
    
  

    public function __construct($args = []){
        foreach (static::$ldapAttributes as $attribute) {
            $this->$attribute = $args[$attribute] ?? "sindefinir";
        }
    }

   

}