<?php
    require('conexionmysql.php');
    $db = new Mysqldb;
    $enlace = $db->conexmysql2();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tag = mysqli_real_escape_string($enlace, $_POST['tag']);
        $devUser = mysqli_real_escape_string($enlace, $_POST['devuser']);
        $guia = mysqli_real_escape_string($enlace, $_POST['guide']);
        $imei = mysqli_real_escape_string($enlace, $_POST['imei']);
        $sim = mysqli_real_escape_string($enlace, $_POST['sim']);
        $fecha = date('Y-m-d'); // Obteniendo la fecha actual sin horas

        if (empty($tag) || empty($devUser) || empty($imei) || empty($sim)) {
            $alerta = 'Los campos no pueden ir vacíos';
        } else {
            $query = "INSERT INTO registros_guias (tag, imei, sim, fecha, guia, devuser) VALUES (?, ?, ?, ?, ?, ?)";
            $agregar = mysqli_prepare($enlace, $query);

            if ($agregar) {
                mysqli_stmt_bind_param($agregar, 'ssssss', $tag, $imei, $sim, $fecha, $guia, $devUser);
                mysqli_stmt_execute($agregar);
                $mensaje = "Campos agregados correctamente";
            } else {
                $alerta = 'Hubo un error al preparar la consulta.';
            }
        }
    }
?>



<div class="notificacion" id="mensaje">
    <?php if ($mensaje) { ?>
        <p class="notificacion__mensaje"><?php echo $mensaje; ?></p>
        <script>
            setTimeout(function() {
                window.location.href = "/index.php?page=envios";
            }, 3000);
        </script>
    <?php } ?>
</div>
