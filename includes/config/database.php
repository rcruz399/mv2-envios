<?php 

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'seguimiento_moviles');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 
    return $db;
}

function conectarDBocs() : mysqli {
    $db = new mysqli('192.168.120.150', 'ocsext', '#sistemaspitiC#123', 'ocsweb');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 
    return $db;
}