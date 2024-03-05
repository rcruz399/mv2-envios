<?php
require('../app.php');
use App\DevUsers;
use App\People;
use App\Moviles;
$devuser = new DevUsers;
$numempleado =  $_POST['devuser'];
$errores = [];

// Revisar si está activo en RH

if ($numempleado) {
    $numEmpleado = $numempleado;

    // Llamada a la API de RRHH
    $devUserData = DevUsers::apirrhh($numEmpleado, true);
    
    $estado = DevUsers::apirrhh($numEmpleado);

    // Buscar en People
    $devuserInPeople = People::findLDAP("noempleado", $numempleado);

    // Buscar en DevUsers
    $devuserInDevUsers = DevUsers::findLDAP("dunumeroempleado", $numempleado);
   
    

    if ($estado ==="SI") {

            // Verificar existencia en People
        if ($devuserInPeople !="sindefinir") {
            // Si existe en People, asignar los datos de People
            $devuser->dunumeroempleado = $devuserInPeople->noempleado;
            $devuser->duusernname = $devuserInPeople->uid;
            $devuser->dunombre = $devuserInPeople->cn ;

        }
       
        
        if ($devuserInDevUsers != "sindefinir") {
            //agregar a errores ya existe un devuser
            $errores[]="El numero de empleado ya tiene un Devuser: ". $devuserInDevUsers->duusernname;
            // Si existe en DevUsers, y tiene asignado un equipo guarda un error
            $movilasignado = Moviles::findLDAP("DeviceAssignedTo", $devuserInDevUsers->duusernname);
            if ($movilasignado != "sindefinir") {
                $errores[]="El usuario: " . $numEmpleado . ", " . $devuserInDevUsers->duusernname . " Ya tiene asignado un equipo";
            }

        } else {
            $devuser->dunumeroempleado = $devUserData['info'][0]['clave'];
            $devuser->duusernname = '' ;
            $devuser->dunombre = $devUserData['info'][0]['nombre']. " " . $devUserData['info'][0]['apepaterno'] ." " . $devUserData['info'][0]['apematerno'] ;
            
        }
    
    }else{
        $errores[]="El usuario no está en RH";
    }

}

$response = ($errores) ? ['error' => true, 'mensaje' => implode("\n", $errores)] : $devuser;
echo json_encode($response);


