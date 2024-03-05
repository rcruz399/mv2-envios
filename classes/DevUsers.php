<?php

namespace App;

class DevUsers extends ActiveRecord {
    // Base DE DATOS
    protected static $dn = "ou=DeviceUsers,dc=transportespitic,dc=com";
    protected static $filtro = "(duusernname=*)";
    protected static $ldapAttributes = [
        'dunumeroempleado',
        'duoficina',
        'duusernname',
        'dunombre',
        'objectclass'
    ];

    // Propiedades de la clase DevUsers
    public $dunumeroempleado;
    public $duoficina;
    public $duusernname;
    public $dunombre;
    public $objectclass;

    public function __construct($args = []){
        foreach (static::$ldapAttributes as $attribute) {
            $this->$attribute = $args[$attribute] ?? "sindefinir";
        }
    }
}
