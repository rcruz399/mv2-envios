<?php
    // Verifica si se ha proporcionado un ID válido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Convierte el ID en un entero
        $id = intval($_GET['id']);
        require('conexionmysql.php');
        $db = new Mysqldb;
        $enlace = $db->conexmysql2();

        // Consulta SQL para eliminar el registro con el ID proporcionado
        $query = "DELETE FROM registros_guias WHERE id = $id";

        // Ejecuta la consulta
        if (mysqli_query($enlace, $query)) {
            exit();
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($enlace);
        }
    } else {
        echo "ID de guía no válido";
    }
?>

<script>
    setTimeout(function() {
        window.location.href = "/index.php?page=envios";
    }, 3000);
</script>