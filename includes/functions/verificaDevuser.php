<?php
require('../app.php');
//print_r($_POST);
use App\Moviles;
use App\DevUsers;

$devUser = $_POST['devuser'];



$response = array();

    
    
    $usuario= DevUsers::findLDAP('duusernname',$devUser);
    
    if ($usuario !== "sindefinir") {
        $response["usuario_existe"] = true;
        $response["usuario"] = $devUser;
        
        // Verificar si tiene un dispositivo asignado
        $movil = Moviles::findLDAP("deviceassignedto",$devUser);
       
        if ($movil !== "sindefinir") {
            $response["tag_asignado"] = true;
            $response["tag"] = $movil->devicetag;
        } else {
            $response["tag_asignado"] = false;
        }

    } else {
        $response["usuario_existe"] = false;
    }
   

echo json_encode($response);
return false;
?>


           
