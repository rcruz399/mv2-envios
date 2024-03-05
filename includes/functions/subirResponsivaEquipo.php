<?php
require('..\app.php');
use App\ResponsivasEquipos;
$responsiva = new  ResponsivasEquipos();


if(isset($_POST['submit'])){
    // Recuperar el archivo PDF
   
    $file = $_FILES['Factura'];
    $facturaFile = $_FILES['Factura'];
    $responsivaFile = $_FILES['Responsiva'];

    $responsiva->id = null;
    $responsiva->oficina = $_POST['oficina'] ;
    $responsiva->usuario = $_POST['usuario'];
    $responsiva->tipo = $_POST['tipo'];
    $responsiva->marca = $_POST['marca'];
    $responsiva->modelo = $_POST['modelo'];
    $responsiva->serie = $_POST['serie'];
    $responsiva->estatus = $_POST['estatus'];
    $responsiva->garantia = $_POST['fecha'];
    $alerta ="alerta-error";
    // Verificar si se cargó al menos un archivo
    if($file['error'] == 4 && $responsivaFile['error'] == 4){ 
        echo '<div class="'. $alerta .'">';
        echo '<h2>';
        echo 'Por favor al menos debe de subir una responsiva o la factura';
        echo '</h2>';
        echo '</div>';
    } else {

        // Verificar si el archivo es un PDF
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileType = pathinfo($responsivaFile['name'], PATHINFO_EXTENSION);
        if($fileType != "pdf" || $responsivaFile != "pdf"){
            echo '<div class="'. $alerta .'">' ;
            echo '<h2>';
            echo "Solo se permiten archivos PDF";
            echo '</h2>';
            echo '</div>';
        } else {
            // Configurar los detalles del archivo adjunto
            if($facturaFile === ""){
                $factname = '';
            }else{
                $factname = 'FACT_' . $responsiva->serie. ".".$fileType;
            }
           
            $respname = 'RESP_' . $responsiva->usuario. '_'.$responsiva->oficina. '_' . $responsiva->serie. "." . $fileType;
            $fileTmpName =  $responsivaFile['tmp_name'];
            $fileTmpName2 = $facturaFile['tmp_name'];
            $fileSize = $responsivaFile['size'];
            $fileSize2 = $facturaFile['size'];

            // Configurar la ruta y el nombre de archivo de destino
            $uploadDir = "c:/laragon/www/mv2/RESPONSIVAS/EQUIPOS/";
            
            $uploadFilefact = $uploadDir . $factname;
            $uploadFileresp = $uploadDir . $respname;
            $responsiva->responsiva =  $respname;
            $responsiva->factura = $factname;




            debuguear($responsiva);
            // Mover el archivo cargado al directorio de destino
            if(move_uploaded_file($fileTmpName, $uploadFileresp)){
                $alerta ="alerta-succes";
                echo '<div class="'. $alerta .'">' ;
                echo '<h2>';
                echo "El archivo " . $respname . " se ha subido con éxito a la carpeta RESPONSIVAS.";
                echo '</h2>';
                echo '</div>';
            } else {
                $alerta ="alerta-error";
                echo '<div class="'. $alerta .'">' ;
                echo '<h2>';
                echo "Hubo un error al subir el archivo PDF.";
                echo '</h2>';
                echo '</div>';
            }

            if(move_uploaded_file($fileTmpName2,  $uploadFilefact)){
                $alerta ="alerta-succes";
                echo '<div class="'. $alerta .'">' ;
                echo '<h2>';
                echo "El archivo " . $factname . " se ha subido con éxito a la carpeta RESPONSIVAS.";
                echo '</h2>';
                echo '</div>';
            } else {
                $alerta ="alerta-error";
                echo '<div class="'. $alerta .'">' ;
                echo '<h2>';
                echo "Hubo un error al subir el archivo PDF.";
                echo '</h2>';
                echo '</div>';
            }

            
            $responsiva-> guardar();
        }
    }
}