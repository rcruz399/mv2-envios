
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
}

require ('conexionmysql.php');
$db = new Mysqldb;
$conexion = $db ->conexmysql2();

if (!$conexion){

    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}
$id= $data['id'];

$query = "update tasks set estado = 0, fecha_actualizado= CURRENT_TIMESTAMP  where id=".$id.";";
$resultado = mysqli_query($conexion, $query);

if($resultado){
    $response['success'] = true;
}else{
    $response['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);