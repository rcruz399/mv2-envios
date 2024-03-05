<?php
if (isset($_POST['action']) && $_POST['action'] === 'agregarDevUser') {
    $nombre = $_POST['nombre'];
    $numeroEmpleado = $_POST['numeroEmpleado'];
    $oficina = $_POST['oficina'];
    $userName = $_POST['userName'];
    //Codigo para debugear codigo
error_reporting(E_ALL);
ini_set("display_errors", 1);
    // Llama a la función agregarDevUser con los datos recibidos
    agregarDevUser($nombre, $numeroEmpleado, $oficina, $userName);
}


function ConectaLDAP() {
    include 'configuraciones.class.php';
    $ldapconn = ldap_connect($ldapserver) or die("Could not connect to LDAP server.");
    if($ldapconn) {
        $ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));
    }
    $err=ldap_error($ldapconn);
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);
    return $ldapconn;

}





function getdatosldap($how,$ofi,$conn) {
    $out='';
    if ($how == "array") {
        $out=array();
    }
    $ldapconn=$conn;
    $result = ldap_search($ldapconn,"ou=DeviceUsers,dc=transportespitic,dc=com", "(duusernname=*)");
    $ldata = ldap_get_entries($ldapconn, $result);
    for ($i=0; $i<$ldata["count"]; $i++) {
        if ($how == "array") {
            $at=$ldata[$i]['duusernname'][0];
            $out[$at]['nombre']=$ldata[$i]['dunombre'][0];
            $out[$at]['numempleado']=$ldata[$i]['dunumeroempleado'][0];
            $out[$at]['usuario']=$ldata[$i]['duusernname'][0];
        }
        if ($how == "exists") {
            return $ldata["count"];
        }
    }
    return $out;
}


function apirh($clave){

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
    curl_close($ch);

    $data = json_decode($response, true);

 
    if(isset($data["info"][0]["fechabaja"])!=null){
       $activo="NO";
    }else if(isset($data["Data"]) && $data["Data"]=="Error"){
        $activo="error";
    }else{
        $activo="SI";
    }
    return $activo;
}


function GetCellsFromLDAP($como) {
    include 'configuraciones.class.php';
    $how="array";
    $err='';
    $data='';
    $out='';
    if ($how == "array") {
        $out=array();
        $outb=array();
    }
    $ldapconn=ConectaLDAP();
    //error_reporting(E_ALL);
    //ini_set('display_errors', 'On');
    set_time_limit(30);
    $array1= array();
    //echo $how;
    if ($como == "active" ) {
        $result = ldap_search($ldapconn,"ou=Celulares,ou=Devices,dc=transportespitic,dc=com", "(DeviceTAG=*)") or die ("Error in search query: ".ldap_error($ldapconn));
    } else {
        if ($como == "poractivar" ) {
            $result = ldap_search($ldapconn,"ou=Celulares,ou=Devices,dc=transportespitic,dc=com", "deviceimei=PORASIGNAR") or die ("Error in search query: ".ldap_error($ldapconn));
        } else {
            $result = ldap_search($ldapconn,"ou=Celulares,ou=Devices,dc=transportespitic,dc=com","(DeviceTAG=*)");
        }
    }
    $err=ldap_error($ldapconn);
    $ldata = ldap_get_entries($ldapconn, $result);
    //$ldata["count"]."<br>";
    //echo "<pre>";
    //print_r($ldata);
    //echo "</pre>";
    for ($i=0; $i<$ldata["count"]; $i++) {
        //array_push($array1,$ldata[$i][$what][0]);
        //echo "<pre>";
        //print_r($ldata);
        //echo "</pre>";        
       // if ($how == "htmltable") {
         //   $out .= "<tr><td>".$ldata[$i]['uid'][0]."</td></tr>";    
       // }
       
           // array_push($out,$ldata[$i]['devicelastseen'][0]);
           if (isset($ldata[$i]['devicelastseen'][0])) {
            array_push($out, $ldata[$i]['devicelastseen'][0]);
        } else {
            // Obtener la fecha de hoy en formato deseado (por ejemplo, 'Y-m-d')
            $fechaHoy = date('Y-m-d');
        
            // Agregar la fecha de hoy al array $out
            array_push($out, $fechaHoy);
        }
           // $serie=$ldata[$i]['deviceserial'][0];
           if (isset($ldata[$i]['deviceserial'][0])) {
            $serie = $ldata[$i]['deviceserial'][0];
        } else {
            $serie = "pordefinir";
        }
          //  $imei=$ldata[$i]['deviceimei'][0];
          if (isset($ldata[$i]['ddeviceimei'][0])) {
            $imei = $ldata[$i]['deviceimei'][0];
        } else {
            $imei = "pordefinir";
        }
            //$tag=$ldata[$i]['devicetag'][0];
            //echo "perroi ".$ldata[$i]['devicetag'][0]."--".$imei."--"."<br>";
            $llave = $imei;
            if ($como == "poractivar") {
                if (isset($ldata[$i]['devicetag'][0])) {
                    $tag = $ldata[$i]['devicetag'][0];
                    $llave = $tag;
                } else {
                    $llave = "TAG_NO_DEFINIDA"; // Otra acción adecuada en caso de que la etiqueta no esté definida
                }
            }

            $outb[$llave]['devicelastseen'] = isset($ldata[$i]['devicelastseen'][0]) ? $ldata[$i]['devicelastseen'][0] : "PORDEFINIR";
            $outb[$llave]['deviceserial'] = isset($ldata[$i]['deviceserial'][0]) ? $ldata[$i]['deviceserial'][0] : "PORASIGNAR";
            $outb[$llave]['deviceimei'] = isset($ldata[$i]['deviceimei'][0]) ? $ldata[$i]['deviceimei'][0] : "PORDEFINIR";
            $outb[$llave]['deviceassignedto'] = isset($ldata[$i]['deviceassignedto'][0]) ? $ldata[$i]['deviceassignedto'][0] : "PORDEFINIR";
            $outb[$llave]['devicetag'] = isset($ldata[$i]['devicetag'][0]) ? $ldata[$i]['devicetag'][0] : "TAG_NO_DEFINIDA";
            $outb[$llave]['deviceoffice'] = isset($ldata[$i]['deviceoffice'][0]) ? $ldata[$i]['deviceoffice'][0] : "PORDEFINIR";
            
           
        
        //return false;
    }

    
    
    return $ldata;
}

function agregarDevUser($nombre, $numeroEmpleado, $oficina, $userName){

    include('conexionldap.php');
// Establecer la conexión LDAP existente
    $ldapConect = new Conexion();
    $getldap = $ldapConect->conectarLDAP();


if (!$getldap) {
    die('No se pudo establecer la conexión LDAP.');
}

// Atributos para el nuevo objeto DeviceUser
$attributes = [
    'dunombre' => $nombre, // Reemplaza con el nombre del usuario
    'dunumeroempleado' => $numeroEmpleado, // Reemplaza con el número de empleado
    'duoficina' => $oficina, // Reemplaza con la oficina
    'duusernname' => $userName, // Reemplaza con el nombre de usuario
    'objectClass' => ['top', 'deviceuser'], // Asegúrate de tener las clases de objetos adecuadas
];

$entry['duusernname']=$userName;
$entry['dunombre']=$nombre;
$entry['dunumeroempleado']=$numeroEmpleado;
$entry['duoficina']=$oficina;
$entry['objectClass'][0] = "deviceuser";


// DN (Distinguished Name) donde se creará el objeto DeviceUser
$dn="duusernname=".$userName.",ou=DeviceUsers,dc=transportespitic,dc=com";

// Intentar agregar el objeto
if (ldap_add($getldap, $dn, $entry)) {
    echo 'Objeto DeviceUser agregado con éxito.';
    print_r("objeto guardado");
} else {
    echo 'Error al agregar el objeto DeviceUser: ' . ldap_error($getldap);
}

// Cerrar la conexión LDAP
ldap_close($getldap);


}

?>

