<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU PRINCIPAL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

</head>
<body>

<?php

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);

    session_start();
    if (isset($_SESSION['user'])) {
        $usuario= $_SESSION['user'];
    } else {
        header("Location: login.php");
    }

    require('includes/app.php'); 

?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/main.js"></script>

    <div class="main active">
        <div class="side-navbar active">
            
            <ul>

                <li>
                    <a href="#">
                        <span class="icon"><i class='bx bxs-dashboard'></i></span>
                        <span class="text">
                            <h2>Moviles pitic</h2>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=inicio">
                        <span class="icon"><abbr title="Inicio"><i class='bx bxs-home-circle'></i></abbr></span>
                        <span class="text">Inicio</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=reportes">
                        <span class="icon"><abbr title="Reportes"><i class='bx bxs-report'></i></abbr></span>
                        <span class="text">Reportes</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=newCell">
                        <span class="icon"><abbr title="Nuevo Celular"><i class='bx bxs-phone'></i></abbr></span>
                        <span class="text">Nuevo celular</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=newdevuser">
                        <span class="icon"><abbr title="Nuevo Usuario"><i class='bx bxs-user-plus'></abbr></i></span>
                        <span class="text">Nuevo usuario</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=acciones">
                        <span class="icon"><abbr title="Acciones"><i class='bx bx-task'></i></abbr></span>
                        <span class="text">Acciones</span>
                    </a>
                </li>

                <li>
                    <a id="responsivas" onclick="toggleSubmenu('responsivas')">
                        <span class="icon"><abbr title="Responsivas"><i class='bx bxs-file-pdf'></i></abbr></span>
                        <span class="text">Responsivas</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="index.php?page=responsivas">Moviles</a></li>
                        <li><a href="index.php?page=responsivasequipos">Equipos</a></li>
                    </ul>
                </li>

                <li>
                    <a id="inventario" onclick="toggleSubmenu('inventario')">
                        <span class="icon"><abbr title="Inventario"><i class='bx bxs-devices'></i></abbr></span>
                        <span class="text">Inventario</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="index.php?page=stock_bodega">Stock en Bodega</a></li>
                        <li><a href="index.php?page=inventario">Equipos Asignados</a></li>
                    </ul>
                </li>

                <li>
                    <a href="index.php?page=uso_cero">
                        <span class="icon"><abbr title="Uso Cero"><i class='bx bxs-objects-vertical-bottom'></i></abbr></span>
                        <span class="text">Uso Cero</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=envios">
                        <span class="icon">
                            <abbr title="Uso Cero"><i class='bx bx-trip'></i></abbr>
                        </span>
                        <span class="text">Envios</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=lineas">
                        <span class="icon">
                            <abbr title="Uso Cero"><i class='bx bx-memory-card' ></i></abbr>
                        </span>
                        <span class="text">Lineas</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon"><abbr title="Fierro por la 300"><i class='bx bxs-log-out'></i></abbr></span>
                        <span class="text">salir</span>
                    </a>
                </li>

            </ul>

        </div>

        <div class="content active">
            <div class="top-navbar">
                <div class="bx bx-menu" id="menu-icon"></div>
                <div class="TITLE">
                    <H2>ADMINISTRADOR DE MOVILES</H2>
                </div>
                <div class="profile">
                    <img src="img/profile.png" alt="<?php echo $usuario ." Profile photo";?>">
                    <p><?php echo $usuario; ?></p>
                </div>
            </div>
            <div class="content-main">
            
            <?php
                $contenido = isset($_GET['page']) ? $_GET['page'] : 'inicio';

                if ($contenido === "inventario" || is_numeric($contenido)  ) {
                    include('php/inventario.php');
                }elseif ($contenido === "responsivas") {
                    include('includes/templates/'.$contenido.'/layout.php');
                }elseif ($contenido === "responsivasequipos") {
                    include('includes/templates/'.$contenido.'/layout.php');
                }elseif ($contenido === "newCell") {
                    include('includes/templates/moviles/'.$contenido.'.php');
                }  elseif ($contenido === "newdevuser") {
                    include('includes/templates/devusers/'.$contenido.'.php');
                }  
                else {
                    include('php/'.$contenido.'.php');
                }
            ?>
            </div>
        </div>
    </div>

    <script src="/mv2/js/tareas.js"></script>
</body>
</html>