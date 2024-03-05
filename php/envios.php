<?php 

require ('conexionmysql.php');
$db = new Mysqldb;
$enlace = $db ->conexmysql2();

// Obtener los datos de la página 
$query = "SELECT * FROM registros_guias";
$resultados = mysqli_query($enlace, $query);
$conteoDatos = mysqli_num_rows($resultados);

// Obtener Mes actual
$mesActual = date('F');

// Crear un array para almacenar los datos agrupados por mes y año
$registrosPorMes = array();

// Iterar sobre los resultados y agruparlos por mes y año
while ($datos = mysqli_fetch_assoc($resultados)) {
    $fecha = strtotime($datos['fecha']);
    $mes = date('n', $fecha);
    $anio = date('Y', $fecha);

    if (!isset($registrosPorMes[$anio][$mes])) {
        $registrosPorMes[$anio][$mes] = array();
    }

    $registrosPorMes[$anio][$mes][] = $datos;
}

?>

<div class="menu-stock">
    <h3 class="guias__heading">Envío de Móviles</h3>
    <article class="consultas">
        <div class="botones">
            <a class="botones__guia guia" id="guia" href="#">Registrar</a>
            <input class="botones__buscador" type="search" name="search" id="search" placeholder="Buscador">
        </div>
    </article>
</div>

<div clas="guias" id="guiasEntrada">
    <form class="guias__formulario" id="formGuia" method="POST" action="/index.php?page=datosGuia">
        <div class="guias__close">
            <i class='guias__i bx bx-x' id="close"></i>
        </div>
        <div class="guias__entradas">
            <div class="guias__entrada">
                <label class="guias__label" for="tag">Ingrese el TAG:</label>
                <input class="guias__input" type="text" id="tag" name="tag" placeholder="Ejm. CELTRA992" required>
            </div>

            <div class="guias__entrada">
                <label class="guias__label" for="guide">Ingrese la guía:</label>
                <input class="guias__input" type="text" id="guide" name="guide" placeholder="Ejm. 3-685432" required>
            </div>
        </div>
        <div class="opciones">
            <input class="guias__btn" type="submit"  value="Buscar..">
        </div>
    </form>
</div>

<?php foreach ($registrosPorMes as $anio => $meses) : ?>
    <?php foreach ($meses as $mes => $registros) : ?>
        <div class="listado">
            <div class="listado__seguimiento">
                <div class="conteo">
                    <h2 class="conteo__heading">Listado de Envíos</h2>
                    <p class="conteo__conteo">Mes: <span class="conteo__conteo--span"><?php echo date('F', mktime(0, 0, 0, $mes, 1)); ?></span></p>
                    <p class="conteo__conteo">Año: <span class="conteo__conteo--span"><?php echo $anio; ?></span></p>
                    <p class="conteo__conteo">Total de Envíos: <span class="conteo__conteo--span"><?php echo count($registros); ?></span></p>
                </div>
                <table class="tabla" border="2">
                    <thead class="tabla__listado">
                        <th class="tabla__th">id</th>
                        <th class="tabla__th">tag</th>
                        <th class="tabla__th">imei</th>
                        <th class="tabla__th">sim</th>
                        <th class="tabla__th">fecha</th>
                        <th class="tabla__th">guía de envío</th>
                    </thead>
                    <tbody class="tabla__contenido">
                        <?php foreach ($registros as $registro) : ?>
                            <tr class="tabla__tr">
                                <td class="tabla__td"><?php echo $registro['id'] ?></td>
                                <td class="tabla__td"><?php echo $registro['tag'] ?></td>
                                <td class="tabla__td"><?php echo $registro['imei'] ?></td>
                                <td class="tabla__td"><?php echo $registro['sim'] ?></td>
                                <td class="tabla__td"><?php echo $registro['fecha'] ?></td>
                                <td class="tabla__td tabla__td--guia">
                                    <a class="tabla__td--enlace" href="https://www.transportespitic.com.mx/portalnuevo/guias/rastreo.php">
                                        <?php echo $registro['guia'] ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
