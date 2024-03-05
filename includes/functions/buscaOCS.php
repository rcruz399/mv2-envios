<?php

require('../app.php');
use App\ActiveRecord;
use App\EquiposOCS;
$dbocs = conectarDBocs();

ActiveRecord::setDBocs($dbocs);

$equipoOCS= new EquiposOCS();
$name = $_POST['device'];
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

$resultado = EquiposOCS::consultarSQL($query);


if($resultado){
    $equipoOCS->sincronizar($resultado[0]);
    $equipoOCS->result = "200";
}else{
    $equipoOCS->result = "404";
}


echo json_encode($equipoOCS);







?>
