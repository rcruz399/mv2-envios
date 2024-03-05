<?php 

    require 'funciones.php';
    require 'config/database.php';
    require 'config/ldap.php';
    require __DIR__ . '/../vendor/autoload.php';

    // Conectarnos a la base de datos
    $db = conectarDB();
    //$dbocs = conectarDBocs();
    $ldap = conectarLDAP();

    use App\ActiveRecord;

    ActiveRecord::setDB($db);
    //ActiveRecord::setDBocs($dbocs);
    ActiveRecord::setLDAP($ldap);
