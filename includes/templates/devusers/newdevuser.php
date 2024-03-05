<?php
    use App\Oficinas;
    use App\Moviles;
    $oficinas = Oficinas::all();

    if(isset($_POST['agregar'])){    
        $movil = new Moviles;

    $movil->sincronizar($_POST);

    debuguear($movil);
    $movil->guardarLDAP("crear","movil");
    }
?>

<script src="js/newCell.js"></script>

<div class="contenedor-form">
    <h1>Este sitio está en construcción, favor de no registrar usuarios aquí</h1>
    <h2>Registrar un Nuevo DevUser</h2>
    <form class="editar_formulario" id="formagregar" action="" method="POST">
        <div class="formulario-cajas">
            <div class="solicitud1">
                
                <div> <label for="dunumeroempleado">1.- numero de empleado:</label></div>
                <div><input type="text" name="dunumeroempleado" id="dunumeroempleado" style="width: 250px;" onblur="buscarEmpleado()"></div>     
            
        
            </div>
            <div class="solicitud1">
            
            <div> <label for="dunombre">2.- Nombre Completo:</label></div>
            <div><input type="text" name="dunombre" id="dunombre" style="width: 250px;"></div>     
        
      
            </div>
            <div class="solicitud1">
            
            <div> <label for="duusernname">2.- DevUser:</label></div>
            <div><input type="text" name="duusernname" id="devuser" style="width: 250px;" onblur="validarUsuario()"></div>     
        
      
            </div>

            <div class="solicitud1">
                
                        <div>
                        <label for="deviceoffice">2.- Oficina:</label>
                        </div>
                        <div>
                        <select id="aoficina" name="deviceoffice" class="deviceoffice" style="width: 250px;" required>
                                <option hidden selected></option>
                                <?php
                                foreach ($oficinas as $oficina){
                                    echo '<option value="'. $oficina->id .'">' . $oficina->nombre .  '</option>';
                                } ?> </option>
                                
                        </select>
                        </div>
                
            </div>


        </div>

    
        <div class="area-boton">
                <div>
                    <input type="submit" name="agregar" value="Agregar" id="btn-agregar">
                </div>
            </div>


    </form>
</div>