<?php
include('conexionmysql.php');
$mysql = new Mysqldb();
$getmysql = $mysql->conexmysql();
if (!$getmysql) {
    die('No se pudo conectar: ' . mysqli_error());
}
echo 'Conectado con éxito';
mysqli_close($getmysql);
?>