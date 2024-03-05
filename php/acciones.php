

<div class="layout">

<div class="opcion1" on click="">
    sincronizar LDAP con AirWatch
</div>
<div>
    Generar archivo MACs moviles Wifi
</div>

<div class="mensajes">

    <?php
    if (isset($_GET['ldap'])) {
        ini_set('allow_url_include', 1);
        include('http://192.168.120.179/INFRAESTRUCTURA-DESARROLLO/abgarcia/Infraestructura/scripts/ProvisionNewCell.php');
    }

    
    
    ?>


</div>

</div>

