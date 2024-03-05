<?php

use App\Articulos;
$articulos= Articulos::all();
$errores = Articulos::getErrores();


if (isset($_POST['article'])) {
    $id= $_POST['article'];
    $cantidad = $_POST['cantidad'];
    $articulo = Articulos::find($id);
    $errores = Articulos::getErrores();
    $accion = $_POST['accion'];
}


if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    $args = $_POST;
    $articulo->sincronizar($args);
    $errores = $articulo->validar($accion);
    
    if(empty($errores)) {

        if ($accion === 'salida'){
            $articulo = $articulo->salida($articulo->id,$articulo->cantidad);
        }else{
            $articulo = $articulo->entrada($articulo->id,$articulo->cantidad);
        } 
        $articulo->guardar();
    }
}
?>

<div class='contendedor'>
<div id="alerta">
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
    </div>
<div class = "menu-stock">
<article class="consultas">
    <div class="opciones-d">
        <div class="d actualizar" onclick="entrada()">Entrada de Articulo</div>
        <div class="d actualizar" onclick="salida()">Salida de Articulo</div>

    </div>
    <div id="layout">
        
    </div>
</article>
</div>
<div class="tablas">
<article class="tabla">
        <table id="tabla" class="table table-hover">
        <thead class="encabezado2">
        <tr>
        <th>Articulo</th>
        <th>Modelo</th>
        <th>Cantidad</th>
        </tr>
        </thead>
        <tbody class="tabladato">
        <?php foreach($articulos as $articulo): ?>
            <tr id="<?php echo $articulo->id; ?>">
                <td><?php echo $articulo->articulo; ?></td>
                <td><?php echo $articulo->modelo; ?></td>
                <td><?php echo $articulo->cantidad; ?></td>
            </tr>
        <?php endforeach; ?>
  
        </tbody>
    </table>
</div>




</div>