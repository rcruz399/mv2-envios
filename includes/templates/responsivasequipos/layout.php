<?php
use App\ResponsivasEquipos;
use App\oficinas;
$responsivas = responsivasequipos::all();

?>
<article class="consultas" id="layout" >



    <div id="tabla_filter" class="dataTables_filter">
        <label>Busqueda: </label>
        <input 
            type="search"  
            id="searchTerm" 
            class="input-busc" 
            placeholder="" 
            onkeyup="doSearch()"  
            name="buscador" aria-controls="tabla">
    </div>

        <div class="opciones-d">
            <div class="d actualizar" onclick="generaResponsivaEquipo()"><a href="#">Genera Responsiva</a></div>
            <div class="d actualizar" onclick="subirResponsivaEquipo()"><a href="#">Subir responsiva</a></div>
        </div>
   
</article>
    <article class="tabla">
        <table id="tabla" class="table table-hover">
        <thead class="encabezado2">
        <tr>
        <th>OFICINA</th>
        <th>USUARIO</th>
        <th>TIPO</th>
        <th>MARCA</th>
        <th>MODELO</th>
        <th>SERIE</th>
        <th>ESTATUS</th>
        <th>GARANTIA</th>
        <th>FACTURA</th>
        <th>RESPONSIVA</th>
        </tr>
        </thead>
       <tbody class="tabladato">
       <?php foreach($responsivas as $responsiva): ?>
        <tr>
        <td><?php echo $responsiva->oficina ?></td>
        <td><?php echo $responsiva->usuario ?></td>
        <td><?php echo $responsiva->tipo ?></td>
        <td><?php echo $responsiva->marca?></td>
        <td><?php echo $responsiva->modelo?></td>
        <td><?php echo $responsiva->serie?></td>
        <td><?php echo $responsiva->estatus?></td>
        <td><?php echo $responsiva->garantia?></td>
        <td>
            <img src="/mv2/img/pdf-icon.png" alt="Ver Archivo" class="lzy lazyload--done" width="26" onclick="abrirResponsivaEquipo('<?php echo $responsiva->factura; ?>')">
        </td>
        <td>
            <img src="/mv2/img/pdf-icon.png" alt="Ver Archivo" class="lzy lazyload--done" width="26" onclick="abrirResponsivaEquipo('<?php echo $responsiva->responsiva; ?>')">
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
                 
       </table>
    </article>
