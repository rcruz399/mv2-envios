<?php
 use App\Oficinas;
 use App\Moviles;
 $oficinas = Oficinas::all();

if(isset($_POST['agregar'])){
    debuguear($_POST);
    $movil = new Moviles;
    /*$movil->devicetag = $_POST['taggenerado'];
    $movil->deviceassignedto = $_POST['devuser'];
    $movil->devicebrand = $_POST['devicebrand'];
    $movil->devicedept =$_POST['departamento'];
    $movil->deviceimei = $_POST['deviceimei'];
    $movil->devicemodel = $_POST['devicemodel'];
    $movil->devicenumber = $_POST['telefono'];
    $movil->deviceoffice =$_POST['aoffice'];
    $movil->deviceserial =$_POST['deviceserie'];*/
$movil->sincronizar($_POST);
$movil->guardarLDAP("crear","movil");

    
}
?>

<script src="js/newCell.js"></script>

<div class="contenedor-form">
    <h2>Registrar un Nuevo Equipo Celular</h2>
    <form class="editar_formulario" id="formagregar" action="" method="POST">
        <div class="formulario-cajas">
            <div class="solicitud1">

                
                    <label for="airwatch">1.- Airwatch:</label>
                    <input type="checkbox" name="airwatch" id="airwatch">
                
            </div>

            <div class="solicitud1">
                
                        <div>
                        <label for="deviceoffice">2.- Oficina:</label>
                        </div>
                        <div>
                        <select id="aoficina" name="deviceoffice" class="deviceoffice" style="max-width: 250px;" required>
                                <option hidden selected></option>
                                <?php
                                foreach ($oficinas as $oficina){
                                    echo '<option value="'. $oficina->id .'">' . $oficina->nombre .  '</option>';
                                } ?> </option>
                                
                        </select>
                        </div>
                
            </div>

            <div class="solicitud1">
                
                <div><label for="devicetag">3.- Tag Generado:</label></div>
                <div><input type="text" style="max-width: 100px;" maxlength="9" name="devicetag" id="taggenerado" readonly onclick="GetLastAvailTag()" ></div>
                    
                
            </div>
            <div class="solicitud1">
            
                     <div> <label for="devuser">4.- Devuser:</label></div>
                     <div><input type="text" name="deviceassignedto" id="devuser" onblur="validarUsuario()"></div>       <!-- Campo Devuser (texto) -->
                 
               
            </div>
            <div class="solicitud1">
                <div><label for="telefono">5.- Número de Teléfono:</label></div>
                <div><input type="tel" name="devicenumber" id="telefono" maxlength="10" ></div>    
            </div>
            <div class="solicitud1">
                <div><label for="departamento">6.- Departamento:</label></div>
                <div><input type="text" name="devicedept" id="departamento"></div>
            </div>
            <div class="solicitud1">
                <div><label for="deviceimei">7.- Device IMEI:</label></div>
                <div><input type="text" name="deviceimei" id="deviceimei"  ></div>      
            </div>
            <div class="solicitud1">
                <div><label for="deviceserie">8.- Device Serie:</label></div>
                <div><input type="text" name="deviceserial" id="deviceserie" ></div>
            </div>
            <div class="solicitud1">
                <div><label for="devicebrand">9.- Device Brand:</label></div>
                <div><input type="text" name="devicebrand" id="devicebrand" > </div>       
            </div>
            <div class="solicitud1">
                <div><label for="devicemodel">10.- Device Model:</label></div>
                <div><input type="text" name="devicemodel" id="devicemodel" > </div>       
            </div>




        </div>

    
        <div class="area-boton">
                <div>
                    <input type="submit" name="agregar" value="Agregar" id="btn-agregar">
                </div>
            </div>


    </form>
</div>

