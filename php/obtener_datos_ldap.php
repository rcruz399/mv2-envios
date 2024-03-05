<?php



if ($getldap) {
    $perPage =20;
    if (isset($_GET['page']) && intval($_GET['page']) > 0) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
     // Obtén el valor de 'page' de la solicitud AJAX
    // Calcular el índice de inicio y el número máximo de registros a recuperar
    $startIndex = ($page - 1) * $perPage;
    
    $filter = "(&(devicetag=*)(!(deviceassignedto=BAJA))(!(deviceoffice=BAJA*))(!(deviceassignedto=*PORDEFINIR*))(!(deviceassignedto=*PENDIENTE*))(!(deviceassignedto=*SINASIGNAR*))(!(deviceassignedto=*PORASIGNAR*)))";
    $srch = ldap_search($getldap, "ou=Celulares,ou=Devices,dc=transportespitic,dc=com", $filter);
    $info = ldap_get_entries($getldap, $srch);
    $arr = getdatosldap("array", $info[0]['deviceassignedto'][0], $getldap);
    $cuenta = 0;
    $datos = array();

    for ($i = $startIndex; $i < min($startIndex + $perPage, $info["count"]); $i++) {
        if (isset($arr[$info[$i]['deviceassignedto'][0]])) {
            $employeeNumber = $arr[$info[$i]['deviceassignedto'][0]]['numempleado'];
            $lu = $info[$i]['deviceassignedto'][0];
           $nombre= $arr[$lu]['nombre'];
        } else {
            $employeeNumber = '';
        }
        $dato = array(
            'devicetag' => isset($info[$i]['devicetag'][0]) ? $info[$i]['devicetag'][0] : '',
            'deviceassignedto' => $info[$i]['deviceassignedto'][0],
            'numempleado' => $employeeNumber,
            'nombre' => isset($nombre) ? $nombre : 'sin definir',
            'devicebrand' => isset($info[$i]['devicebrand'][0]) ? $info[$i]['devicebrand'][0] : '',
            'devicemodel' => isset($info[$i]['devicemodel'][0]) ? $info[$i]['devicemodel'][0] : '',
            'deviceimei' => isset($info[$i]['deviceimei'][0]) ? $info[$i]['deviceimei'][0] : '',
            'devicenumber' => isset($info[$i]['devicenumber'][0]) ? $info[$i]['devicenumber'][0] : ''
        );

        
        $datos[] = $dato;
    }






}
$lastPage =round($info["count"] / $perPage);
?>



<div class="opciones-d">
            <div class="d"><a href="?page=<?php echo $page - 1; ?>">Atrás</a></div>
            <div><p class="font-weight-bold ">Página: <?php echo $page; ?> de <?php echo $lastPage; ?></p></div>
            <div class="d"><a href="?page=<?php echo $page + 1; ?>">Siguiente</a></div>
            
</div>

        </div>

    <tbody>
        <?php foreach ($datos as $dato): ?>
            <tr>
                <td><?php echo $dato['devicetag']; ?></td>
                <td><?php echo $dato['deviceassignedto']; ?></td>
                <td><?php echo $dato['nombre']; ?></td>
                <td><?php echo $dato['numempleado']; ?></td>
                <td><?php echo $dato['devicebrand']; ?></td>
                <td><?php echo $dato['devicemodel']; ?></td>
                <td><?php echo $dato['deviceimei']; ?></td>
                <td><?php echo $dato['devicenumber']; ?></td>
               
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="opciones-d">
            
            <div class="d"><a href="?page=<?php echo $page - 1; ?>">Atrás</a></div>
            <div><p class="font-weight-bold ">Página: <?php echo $page; ?> de <?php echo $lastPage; ?>     </p></div>
            <div class="d"><a href="?page=<?php echo $page + 1; ?>">Siguiente</a></div>
            
        </div>