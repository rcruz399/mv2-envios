<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESPONSIVA DE EQUIPO Moviles</title>
   <link rel="stylesheet" href="http://192.168.140.107/mv2/css/responsiva.css">
</head>
<body>

<?php
    //require $_SERVER['DOCUMENT_ROOT'] . '/mv2/includes/app.php';
    require('includes\app.php');
    use App\Moviles;
    use App\DevUsers;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tag = $_POST['tag'];
        $movil = Moviles::findLDAP('devicetag',$tag);
        $usuario =$movil->deviceassignedto;
        $user = DevUsers::findLDAP('duusernname',$usuario);
    }
?>

<div class="contenedor-responsiva">
    <img src="http://192.168.140.107/mv2/img/pitic.png" alt="logo">
    <img src="http://192.168.140.107/mv2/img/eslogan.png" alt="eslogan">
    <p>RESGUARDO DE EQUIPO CELULAR</p>
    <div class="table">
    <TABLE>
        <TR>
            <td>
            <p style="margin: 0;">No. DE EMPLEADO:<?PHP echo " ". $user->dunumeroempleado;?></p>
            <p style="margin: 0;">NOMBRE:<?PHP echo " ". $user->dunombre;?></p>
            <p style="margin: 0;">OFICINA:<?PHP echo " ". $movil->deviceoffice;;?></p>
            </td>
        </TR>
    </TABLE>
    </div>
    <P class="parrafo">
    Recibí por parte de Transportes Pitic, S.A. de C.V., como herramienta de trabajo, el equipo que aparece a continuación, conviniendo expresamente en que la usaré únicamente durante el tiempo que presté mis servicios a la empresa y me hago
    responsable de su buen uso, en caso de extravío me comprometo a reponerlo por uno de las mismas características o pagar su importe a precio de mercado. Entiendo que de no hacer uso adecuado puede generar otros costos a la empresa antes mencionada y autorizo para que se me haga el cargo correspondiente.
    </P>
    <div class="table">
    <table>
        <tr>
            <td>
                <p style="margin: 0;">MODELO:<?PHP echo " ". $movil->devicemodel ;?></p>
                <p style="margin: 0;">IMEI:<?PHP echo " ". $movil->deviceimei ;?></p>
                <p style="margin: 0;">LINEA:<?PHP echo " ". $movil->devicenumber ;?></p>
                <p style="margin: 0;">TAG:<?PHP echo " ". $movil->devicetag ;?></p>
            </td>
        </tr>
    </table>
    </div>
    <P>
    Acepto y autorizo que en dado caso que presenté mi renuncia o deje de prestar mis Servicios a Transportes Pitic, S.A. de C.V. en caso de no hacer entrega del equipo antes citado, se me realice el descuento con valor de mercado del mismo de la liquidación que por ley me corresponde o de mi pago de cierre laboral. Sirva el presente como instrumento de prueba en caso de aclaraciones legales futuras que deban hacerse.
    </P>
    <DIV class="contenedor-firmas">
        <h3>OBSERVACIONES</h3>
        <P>&nbsp;</P>
        <div class="grid-firmas">
            <div class="forma-campo item"><p>Lugar: </p><p class="underline"></p></div>
            <div class="forma-campo item"><p>Fecha: </p><p class="underline"></p></div>
            <div class="item"><p>ACEPTO</p></div>
            <div class="upperline item"><p>Nombre del responsable</p></div>
            <div class="upperline item"><p>Puesto</p></div>
            <div class="upperline item"><p>Firma del responsable</p></div>
        </div>
        
    </DIV>
</div>

</body>

<script>
        // Llamada a la función para imprimir automáticamente cuando la página se carga
        window.onload = function() {
            // Puedes ajustar los parámetros de window.print() según tus necesidades.
            // Por ejemplo, puedes abrir el cuadro de diálogo de impresión directamente o esperar unos segundos antes de imprimir.
            window.print();
        };

        // Redireccionar a index.php después de imprimir
        window.onafterprint = function() {
            setTimeout(function() {
            alert("Redirigiendo al inicio...");
           window.location.href = "/mv2/index.php?page=responsivas";
        }, 500);
        }
    </script>
</html>