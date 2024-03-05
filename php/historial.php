<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilos2.css">
    <link rel="shortcut icon" href="../img/multifuncional.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Impresoras - Historial</title>
</head>

<?php
session_start();
if (isset($_SESSION['user'])) {
} else {
    header("Location: ../login.php");
}
$i = 0;
$sesion = $_SESSION['user'];
?>

<body>


    <header id="cabecera">
        <div class="logo-empresa">
            <img src="../img/logo_adobe.png" alt="">
        </div>

        <div class="titulo">


            <div class="titulo-nombre">
                <h1 class="dm">Historial Impresoras</h1>
            </div>
            <div class="titulo-imagen"> <img class="pitic" src="../img/multifuncional.png" alt=""></div>
        </div>

        <div class="sup" id="sup">
            <div class="sup-mensaje">
                <p>Bienvenido:<?php echo "<b>" . $_SESSION['user'] . "</b>"  ?></p>
            </div>
            <div class="sup-men">
                <a href="../logout.php">Cerrar sesion</a>
            </div>

        </div>


    </header>

    <script>
        function doSearch() {
            const tableReg = document.getElementById('tabla');
            const searchText = document.getElementById('searchTerm').value.toLowerCase();
            let total = 0;

            // Recorremos todas las filas con contenido de la tabla
            for (let i = 1; i < tableReg.rows.length; i++) {
                // Si el td tiene la clase "noSearch" no se busca en su cntenido
                if (tableReg.rows[i].classList.contains("noSearch")) {
                    continue;
                }

                let found = false;
                const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                // Recorremos todas las celdas
                for (let j = 0; j < cellsOfRow.length && !found; j++) {
                    const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                    // Buscamos el texto en el contenido de la celda
                    if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                        found = true;
                        total++;
                    }
                }
                if (found) {
                    tableReg.rows[i].style.display = '';
                } else {
                    // si no ha encontrado ninguna coincidencia, esconde la
                    // fila de la tabla
                    tableReg.rows[i].style.display = 'none';
                }
            }

            // mostramos las coincidencias

        }
    </script>

    <script type="text/javascript">
        //la funcion de busqueda ase una busqueda en la tabla y regresa los resultados
        function busquedaPorOfficina() {
                
            var select = document.getElementById('officinas');
            var optionSelect = select.options[select.selectedIndex]; //obtenemos las opciones que hay dentro del select

            var tabla = document.getElementById('datos'); //Obtenemos la tabla
            var Pbusqueda = optionSelect.value; //obtenemos el value que esta en las obciones de la tabla
            //Se ase un recorrido a la tabla
            for (var i = 1; i < tabla.rows.length; i++) {
                var cellsOfRow = tabla.rows[i].getElementsByTagName('td') //obtiene todos los objetos'td' de la tabla y los guarda en un array
                var found = false; //puntero

                for (var j = 0; j < cellsOfRow.length && !found; j++) {

                    //si encuentra coincidencia
                    if (cellsOfRow[j].innerHTML === Pbusqueda) {
                        found = true;

                    } //si la opcion esta vacia en la busqueda found es true para que muestre todo el recorrdio
                    else if (Pbusqueda == "") {
                        found = true;
                    }
                }
                if (found) {
                    tabla.rows[i].style.display = '';
                } else {
                    tabla.rows[i].style.display = 'none';

                }
            }
        }
    </script>


    <?php
    include('conexionmysql.php');
    $mysqlConect = new Mysqldb();
    $getmysql = $mysqlConect->conexmysql();
    ?>


    <article class="consultas">
        <div class="input-buscador">
            <div class="label-buscador">
                <label for="">Buscador: </label>

            </div>
            <div>
                <abbr title="Ya puedes buscar por usuario, nombre, oficina e incluso por puesto "> <input class="input-busc" id="searchTerm" onkeyup="doSearch()" type="text" name="buscador"></abbr>
            </div>
        </div>
    </article>

    <article class="opciones">
        <div class="opciones-agregar">
            <div class="i">
            </div>
        </div>

        <div class="opciones-d">
            <div class="d actualizar"><a href="">Actualizar</a></div>
            <div class="d alerta"><a href="../index.php">Impresoras</a></div>
            <!--<div class="i alerta"><a href="https://transportespitic.com/sistemas/caso_soporte.php">Historial</a></div>-->
        </div>
    </article>

    <article class="tabla">
        <?php
        echo '<table id="tabla" class="table table-hover">';
        echo '<thead class="encabezado2"><tr><th>ID</th><th>MODIFICADOR</th><th>TAG ANTERIOR</th><th>TAG ACTUAL</th><th>MOVIMIENTO</th><th>FECHA</th></tr></thead>';
        if ($getmysql) {
            $mysql2= "select * from impresora_historial ORDER BY Id DESC LIMIT 100 ";
            $result= mysqli_query($getmysql,$mysql2);

            echo '<tbody class="tabladato">';
            while ($file=mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>' . $file["Id"] . '</td>';
                echo '<td>' . $file["usuario"] . '</td>';
                echo '<td>' . $file["tagant"] . '</td>';
                echo '<td>' . $file["tagact"] . '</td>';
                echo '<td>' . $file["movimiento"] . '</td>';
                echo '<td>' . $file["fecha"] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';

            mysqli_close($getmysql);
            echo '<script>window.history.replaceState(null, null, window.location.href);</script>';
        }
        echo '</table>';
        ?>

    </article>

    <footer>
        <p class="copyright">© 2022 - Desarrollo y Mantenimiento: Andres Salazar (gsalazar) - Versión del sitio 3.0</p>
    </footer>
</body>

</html>