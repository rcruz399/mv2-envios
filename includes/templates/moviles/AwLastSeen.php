<?php

    use App\DevUsers;
    use App\Moviles;
    use App\Oficinas;
    $oficinas = Oficinas::all();



    function QueryToAirwatchAPI() {
        define('AIRWATCH_API_RESULT_OK', 'AIRWATCH_API_RESULT_OK');
        //$basic_auth = base64_encode("infra:TP1nghm0R1hM0zaRqfCck4U");
    // $basic_auth = base64_encode("infra:TP1nghm0R1hM0zaRqfBck4U");
        $basic_auth = base64_encode("infra:TP1nghm0R1hM0zaRqfDck4U");

        //$basic_auth = base64_encode("infra:TP1nghm0R1hM0zaRqfZck4U");


        //$basic_auth='amZlcmlhOkxldHR5b3J0ZWdh';
        $fechaActual = date('Y-m-d');
        $fechaLimite = date('Y-m-d', strtotime('-20 days', strtotime($fechaActual)));

        $ch = curl_init();
        $api_key='Zbh2S+e0ejNOibdtwlFDFssflXSeCniu2oh1/7lVg5A=';
        $baseurl="https://as257.awmdm.com";
        $endpoint='/API/mdm/devices/search?lastseen='. $fechaLimite;
        $url = $baseurl.$endpoint;
        $headers = ['aw-tenant-code: '.$api_key,'Authorization: Basic '.$basic_auth,'Accept: application/json'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');    
        


        $ch_result = curl_exec($ch);
        $infos = curl_getinfo($ch);
    
    // Verifica si la respuesta es un error 401 (Unauthorized)
    if ($infos['http_code'] == 401) {
        return "UNAUTH";
    }

    // Si el código HTTP no es 200, hay un error
    if ($infos['http_code'] != '200') {
        return "Error HTTP: " . $infos['http_code'];
    }

    // Decodificar el resultado JSON en un array asociativo
    $result['data'] = json_decode($ch_result, true);

    // Cerrar la conexión cURL
    curl_close($ch);

    return $result['data'];
    }

    $moviles = QueryToAirwatchAPI();

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
        <div class="input-buscador">
            <div class="label-buscador">
                <label for="aoficina">Oficina:</label>
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
        </div>

    </article>
<article class="tabla">
<h1><?php echo "Se encontraron: ". $moviles['Total']. " Moviles sin uso"?></h1>
    <table id="tabla" class="table table-hover">
        <thead class="encabezado2">
            <tr>
                <th>Ultima Conexión</th>
                <th>TAG</th>
                <th>OFICINA</th>
                <th>ASIGNADO A</th>
                <th>EQUIPO</th>
                <th>IMEI AW</th>
                <th>IMEI LDAP</th>
                <th>Activo en RH</th>
            </tr>
        </thead>
        
            <tbody class="tabladato">
                <?php
                    for ($i=0; $i < $moviles['Total'] ; $i++) { 
                        //calcula los días sin usarse
                        $fechaLastSeen = new DateTime($moviles['Devices'][$i]['LastSeen']);
                        $fechaHoy = new DateTime();
                        $diferencia = $fechaHoy->diff($fechaLastSeen);
                        $diasTranscurridos = $diferencia->days;

                        //query a LDAP buscamos el tag  y nos traemos el devuser 
                            $tag = $moviles['Devices'][$i]['DeviceFriendlyName'];
                            $movil = Moviles::findLDAP('devicetag',$tag);
                            $oficina = isset($movil ->deviceoffice ) ? $movil ->deviceoffice : "";
                            $imei = isset($movil ->deviceimei) ? $movil ->deviceimei : "";
                            


                        //Query a LDAP Buscamos datos del devuser
                            if (is_object($movil)) {
                                $usuario = $movil->deviceassignedto;
                        
                                // Query a LDAP Buscamos datos del devuser
                                $user = DevUsers::findLDAP('duusernname', $usuario);
                        
                                // Verificar si $user es un objeto antes de intentar acceder a sus propiedades
                                if (is_object($user)) {
                                    // Ahora puedes acceder a las propiedades de $user sin generar advertencias
                                    $vuser = $user->dunombre;
                                } else {
                                    $vuser= '';
                                }
                            }

                        //API RH verificamos si está registrado
                        
                        $numempleado = isset($user->dunumeroempleado) ? $user->dunumeroempleado : null;
                          $estado = DevUsers::apirrhh($numempleado);


                        //tabla row
                        echo '<tr>';
                        echo '<td><b>' . $diasTranscurridos. ' Días<b></td>';
                        echo '<td>' . $moviles['Devices'][$i]['DeviceFriendlyName'] . '</td>';
                        echo '<td>' . $oficina . '</td>';
                        echo '<td>' .$vuser. '</td>';
                        echo '<td>' . $moviles['Devices'][$i]['Model'] . '</td>';
                        echo '<td>' . $moviles['Devices'][$i]['Imei'] . '</td>';
                        echo '<td>' . $imei . '</td>';
                        echo '<td>' . $estado . '</td>';
                        echo '</tr>';
                    }                
                ?>
            </tbody>
    </table>
    
</article>
