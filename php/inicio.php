
<h1 class="content-title">Pendientes en Telefonía</h1>
<div class="content-title icon-minus"><i class='bx bxs-plus-circle' id="nuevaTarea"></i></div>
<div class="content-cards" id='layout'>
    <?php
    require ('conexionmysql.php');
    $db = new Mysqldb;
    $conexion = $db ->conexmysql2();

   
    if ($_SERVER['REQUEST_METHOD']=== 'POST') {
        
        $titulo = $_POST['titulo'];
        $contenido = $_POST['tarea'];
        $query = "INSERT INTO tasks (titulo,contenido,autor,estado) VALUES ('${titulo}','${contenido}',1,1);";
        $resultado = mysqli_query($conexion, $query);
        header("Location: /mv2/");
        exit;

    }

    if (!$conexion){

        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    }

    $query = "SELECT tasks.*, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS nombre_autor FROM tasks INNER JOIN usuarios ON tasks.autor = usuarios.id where estado=1 ";
    $resultado = mysqli_query($conexion, $query);

    while ($fila =  mysqli_fetch_assoc($resultado)) { ?>
            <div class="card">
                <i class='bx bxs-minus-circle icon-minus' onclick="task_del('<?php echo $fila['id']?>')" ></i>
                <h3><?php echo $fila['titulo'] ?></h3><br><br>
                <p><?php echo $fila['contenido'] ?></p><br>
                <em><?php echo $fila['nombre_autor']?></em><br>
                <em><?php echo $fila['fecha_registro']?></em>
            </div>

           <?php }
            mysqli_close($conexion);
                    
     ?>

</div>
