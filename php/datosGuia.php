<?php

    use App\Moviles;
    use App\DevUsers;

    $fecha_actual = date('Y-m-d');
    
    require ('conexionmysql.php');
    $db = new Mysqldb;
    $conexion = $db ->conexmysql2();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tag = $_POST['tag'];
        $guia = $_POST['guide'];
        $movil = Moviles::findLDAP('devicetag',$tag);
        $usuario =$movil->deviceassignedto;
        $user = DevUsers::findLDAP('duusernname',$usuario);
    } 

?>


<h2>Datos</h2>

<div class="guias" id="guiasEntrada">

    <form class="guias__recibimiento" method="POST" action="/index.php?page=guardadDatosGuia">

        <div class="guias__entradas">
            <div class="guias__entrada">
                <label class="guias__label" for="tag">tag:</label>
                <input 
                    class="guias__input guias__block" 
                    type="text" 
                    id="tag" 
                    name="tag" 
                    value="<?php echo $movil->devicetag; ?>"
                    readonly
                >
            </div>

            <div class="guias__entrada">
                <label class="guias__label" for="tag">devuser:</label>
                <input 
                    class="guias__input guias__block" 
                    type="text" 
                    id="devuser" 
                    name="devuser" 
                    value="<?php echo $user->dunombre; ?>"
                    readonly
                >
            </div>
            <div class="guias__entrada">
                <label class="guias__label" for="tag">imei:</label>
                <input 
                    class="guias__input guias__block" 
                    type="number" 
                    id="imei" 
                    name="imei"
                    value="<?php echo $movil->deviceimei; ?>"
                    readonly
                >
            </div>

            <div class="guias__entrada">
                <label class="guias__label" for="tag">sim:</label>
                <input 
                    class="guias__input guias__block" 
                    type="number" 
                    id="sim" 
                    name="sim"
                    value="<?php echo $movil->devicenumber; ?>"
                    readonly
                >
            </div>

            <div class="guias__entrada">
                <label class="guias__label" for="tag">fecha:</label>
                <input 
                    class="guias__input guias__block" 
                    type="date" 
                    id="tag" 
                    name="fecha"
                    value="<?php echo $fecha_actual; ?>"
                    readonly
                >
            </div>

            <div class="guias__entrada">
                <label class="guias__label" for="guide">Ingrese la guia:</label>
                <input 
                    class="guias__input guias__block" 
                    type="text" 
                    id="guide" 
                    name="guide"
                    value="<?php echo $guia; ?>"
                >
            </div>

        </div>
        <div class="opciones">
            <input class="guias__btn" type="submit" value="Guardar">
            <a class="guias__btn guias__btn--red" href="/index.php?page=envios">Cancelar</a>
        </div>
    </form>
</div>