


    <?php
    use App\Moviles;
    use App\DevUsers;
    use App\Oficinas;
    $oficinas = Oficinas::all();
    $moviles = Moviles::allLDAP();
    ?>
<script></script>
    <div id="editar"></div>
    <div id="agregar"></div>

    <?php



    if (isset($_POST['agregar'])) {
        $abrand = $_POST["abrand"];
        $adept = $_POST["adept"];
        $aip = $_POST["aip"];
        $amac = $_POST["amac"];
        $amodel = $_POST["amodel"];
        $aoffice = $_POST["aoffice"];
        $aserial = $_POST["aserial"];
        $atag = $_POST["atag"];

        if ($getldap) {
            ldap_set_option($getldap, LDAP_OPT_PROTOCOL_VERSION, 3);

            $filter = "(|(devicetag=$atag)(deviceip=$aip)(devicemac=$amac))";
            $srch = ldap_search($getldap, "ou=Impresoras,ou=Devices,dc=transportespitic,dc=com", $filter);
            $count = ldap_count_entries($getldap, $srch);
            if ($count == 1) {
                echo "<script>alert('El TAG, IP o MAC ya existe'); window.history.replaceState(null, null, window.location.href);</script>";
            } else {
                $dn = "DeviceTAG=$atag,ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";
                $r = ldap_bind($getldap, "cn=feria,dc=transportespitic,dc=com", "sistemaspitic");
                $entry['devicebrand'] = $abrand;
                $entry['deviceip'] = $aip;
                $entry['devicemac'] = $amac;
                $entry['deviceoffice'] = $aoffice;
                $entry['deviceserial'] = $aserial;
                $entry['devicetag'] = $atag;
                $entry['objectclass'][0] = "top";
                $entry['objectclass'][1] = "DeviceInfo";
                $a = ldap_add($getldap, $dn, $entry);

                if ($getmysql && $a) {
                    date_default_timezone_set('US/Arizona');
                    $motivo = "Agregar";
                    $atag2 = "No existe";
                    $mysql = "INSERT INTO impresora_historial (usuario,tagant,tagact,movimiento,fecha) Values(?,?,?,?,?)";
                    $sentmysql = mysqli_prepare($getmysql, $mysql);
                    mysqli_stmt_bind_param($sentmysql, "sssss", $sesion, $atag2, $atag, $motivo, $Hora_de_Registro);
                    mysqli_stmt_execute($sentmysql);
                    mysqli_stmt_close($sentmysql);
                    mysqli_close($getmysql);

                    echo "<script>alert('se agrega TAG: $atag '); window.history.replaceState(null, null, window.location.href); </script>";
                } else {
                    echo "<script>alert('No se agrego el TAG :('); window.history.replaceState(null, null, window.location.href); </script>";;
                }
            }
        } else {
            echo "No se pudo conectar al servidor LDAP";
        }
    }

    if (isset($_POST['editar'])) {
        
        $tag= $_POST["devicetag"];
        $entry ['devicetag']= $_POST["devicetag"];
        $entry ['deviceassignedto']= $_POST["deviceassignedto"];
        $entry ['devicebrand']= $_POST["devicebrand"];
        $entry ['devicemodel']= $_POST["devicemodel"];
        $entry ['deviceimei']= $_POST["deviceimei"];
        $entry ['deviceserial']= $_POST["deviceserial"];
        $entry ['deviceserial']= $_POST["deviceserial"];

        Moviles::actualizarLDAP($entry);

       

        exit;
        

        if ($getldap) {
            ldap_bind($getldap, "cn=feria,dc=transportespitic,dc=com", "sistemaspitic");
            $filter = "(|(devicetag=$etag)(deviceip=$eip)(devicemac=$emac))";
            $srch = ldap_search($getldap, "ou=Impresoras,ou=Devices,dc=transportespitic,dc=com", $filter);
            $count = ldap_count_entries($getldap, $srch);
            if ($count > 1) {
                echo "<script>alert('El TAG, IP o MAC ya existe'); window.history.replaceState(null, null, window.location.href);</script>";
            } else {
                if ($etag == $etag2) {
                    // Asociar con el dn apropiado para dar acceso de actualización
                    ldap_set_option($getldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                    $r = ldap_bind($getldap, "cn=feria,dc=transportespitic,dc=com", "sistemaspitic");
                    $dn = "DeviceTAG=$tag,ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";

                    // Preparar los datos
                    $entry['devicebrand'] = $ebrand;
                    $entry['devicemodel'] = $emodel;
                    $entry['deviceip'] = $eip;
                    $entry['devicemac'] = $emac;
                    $entry['devicemodel'] = $emodel;
                    $entry['deviceoffice'] = $eoffice;
                    $entry['deviceserial'] = $eserial;
                    // Agregar datos al directorio

                    $r = ldap_modify($getldap, $dn, $entry);
                    if ($getmysql && $r) {

                        date_default_timezone_set('US/Arizona');
                        $Hora_de_Registro = date('Y-m-d H:i:s');
                        $motivo = "Editar";
                        $mysql = "INSERT INTO impresora_historial (usuario,tagant,tagact,movimiento,fecha) Values(?,?,?,?,?)";
                        $sentmysql = mysqli_prepare($getmysql, $mysql);
                        mysqli_stmt_bind_param($sentmysql, "sssss", $sesion, $etag2, $etag, $motivo, $Hora_de_Registro);
                        mysqli_stmt_execute($sentmysql);
                        mysqli_stmt_close($sentmysql);
                        mysqli_close($getmysql);

                        echo "<script>alert('Se modifico el tag: [ $etag ] '); window.history.replaceState(null, null, window.location.href);</script>";
                    } else {
                        echo "<script>alert('No se modifico :('); window.history.replaceState(null, null, window.location.href);</script>";
                    }
                } else {
                    ldap_set_option($getldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                    ldap_bind($getldap, "cn=feria,dc=transportespitic,dc=com", "sistemaspitic");
                    $dn = "DeviceTAG=$etag2,ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";
                    $newrdn = "DeviceTAG=$etag";
                    $newparent = "ou=ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";
                    $r = ldap_rename($getldap, $dn, $newrdn, $newparent, true);

                    $dn = "DeviceTAG=$etag,ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";

                    // Preparar los datos
                    $entry['devicebrand'] = $ebrand;
                    $entry['devicemodel'] = $emodel;
                    $entry['deviceip'] = $eip;
                    $entry['devicemac'] = $emac;
                    $entry['devicemodel'] = $emodel;
                    $entry['deviceoffice'] = $eoffice;
                    $entry['deviceserial'] = $eserial;
                    // Agregar datos al directorio

                    $m = ldap_modify($getldap, $dn, $entry);

                    if ($getmysql && $m) {
                        date_default_timezone_set('US/Arizona');
                        $motivo = "Eliminar";
                        $etag2 = "No existe";
                        $mysql = "INSERT INTO impresora_historial (usuario,tagant,tagact,movimiento,fecha) Values(?,?,?,?,?)";
                        $sentmysql = mysqli_prepare($getmysql, $mysql);
                        mysqli_stmt_bind_param($sentmysql, "sssss", $sesion, $etag, $etag2, $motivo, $Hora_de_Registro);
                        mysqli_stmt_execute($sentmysql);
                        mysqli_stmt_close($sentmysql);
                        mysqli_close($getmysql);

                        echo "<script>alert('Se Elimino el tag: [ $etag ] '); window.history.replaceState(null, null, window.location.href);</script>";
                    } else {
                        echo "<script>alert('No se modifico :('); window.history.replaceState(null, null, window.location.href);</script>";
                    }
                }
            }
        }
    }

    if (isset($_POST['eliminar'])) {
        if ($getldap) {
            $etag = $_POST['etag'];
            $dn = "DeviceTAG=$etag,ou=Impresoras,ou=Devices,dc=transportespitic,dc=com";
            ldap_bind($getldap, "cn=feria,dc=transportespitic,dc=com", "sistemaspitic");
            $d = ldap_delete($getldap, $dn);
            $Hora_de_Registro = date('Y-m-d H:i:s');
            if ($getmysql && $d) {
                date_default_timezone_set('US/Arizona');
                $motivo = "Eliminar";
                $etag2 = "No existe";
                $mysql = "INSERT INTO impresora_historial (usuario,tagant,tagact,movimiento,fecha) Values(?,?,?,?,?)";
                $sentmysql = mysqli_prepare($getmysql, $mysql);
                mysqli_stmt_bind_param($sentmysql, "sssss", $sesion, $etag, $etag2, $motivo, $Hora_de_Registro);
                mysqli_stmt_execute($sentmysql);
                mysqli_stmt_close($sentmysql);
                mysqli_close($getmysql);

                echo "<script>alert('se elimina TAG: $etag '); window.history.replaceState(null, null, window.location.href); </script>";
            } else {
                echo "<script>alert('No se elimino el TAG :('); window.history.replaceState(null, null, window.location.href); </script>";;
            }
        } else {
            echo "<script>alert('no hay conexion hacia LDAP'); window.history.replaceState(null, null, window.location.href);</script>";
        }
    }

    ?>

    <article class="consultas">
        
            <div id="tabla_filter" class="dataTables_filter">
            <label>Busqueda: <input type="search" input class="input-busc" id="searchTerm" onkeyup="doSearch()"  name="buscador"></label>

            </div>

            <div>
                <select id="officinas" name="aoffice" class="ofi input-busc" onchange="busquedaPorOfficina()">
                    <option value="">Todas</option>
                    <?php
                    foreach ($oficinas as $oficina){
                        echo '<option value="'. $oficina->id .'">' . $oficina->nombre .  '</option>';
                    }
                    ?>

                </select>
            </div>

  
    

        <div class="opciones-d">
            <div class="d actualizar"><a href="">Actualizar</a></div>
            <div class="d actualizar"><a href="../movil/">Asignados</a></div>
            <div class="d actualizar"><a href="celulares.php">Celulares</a></div>
            <div class="d actualizar"><a href="usuarios.php">Usuarios</a></div>
            <div class="d actualizar"><a href="bajas.php">Bajas</a></div>
        </div>
        <div id="layout">
            
        </div>
    </article>


    
    <article class="tabla">
        <table id="tabla" class="table table-hover">
        <thead class="encabezado2">
        <tr>
        <th>TAG</th>
        <th>OFICINA</th>
        <th>USUARIO</th>
        <th>NOMBRE</th>
        <th>DEPARTAMENTO</th>
        <th>MARCA</th>
        <th>MODELO</th>
        <th>IMEI</th>
        <th>SERIE</th>
        <th>TELEFONO</th>
        <th>REASIGNAR</th>
        </tr>
        </thead>
        <tbody class="tabladato">
        <?php foreach($moviles as $movil): ?>
           <?php  $usuario = $movil->deviceassignedto;
            $user = DevUsers::findLDAP('duusernname',$usuario);
           ?>
            <tr id="<?php echo $movil->devicetag; ?>">
                <td><?php echo $movil->devicetag; ?></td>
                <td><?php echo $movil->deviceoffice; ?></td>
                <td><?php echo isset($usuario) ? $usuario : "sindefinir"; ?></td>
                <td><?php echo isset($user->dunombre) ? $user->dunombre : ""; ?></td>
                <td><?php echo $movil->devicedept; ?></td>
                <td><?php echo $movil->devicebrand; ?></td>
                <td><?php echo $movil->devicemodel; ?></td>
                <td><?php echo $movil->deviceimei; ?></td>
                <td><?php echo $movil->deviceserial; ?></td>
                <td><?php echo $movil->devicenumber; ?></td>
                <td><p class="editar" onclick="editarLDAP('<?php echo $movil->devicetag; ?>')">Editar<i class='bx bxs-edit'></i></p></td>
            </tr>
        <?php endforeach; ?>
  
        </tbody>
    </table>
    </article>


    <footer>
        <p class="copyright">© 2023 - Desarrollo y Mantenimiento: Abraham Garcia (abgarcia) - Versión del sitio 5.0</p>
    </footer>

   
</body>

</html>