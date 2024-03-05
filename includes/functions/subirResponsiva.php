<?php
require('..\app.php');
use App\Responsivas;
$responsiva = new  Responsivas();


if(isset($_POST['submit'])){
    // Recuperar el archivo PDF
   
    $file = $_FILES['ARCHIVO'];
    $responsiva->id = null;
    $responsiva->tag= $_POST['tag'] ;
    $responsiva->oficina= $_POST['oficina'];
    $responsiva->devuser= $_POST['devuser'];
    $responsiva->fecha_entrega = $_POST['fecha'];
    $responsiva->usersis = $_POST['usersis'];
    $responsiva->estatus = $_POST['estatus'];
    
    $alerta ="alerta-error";
    // Verificar si se cargó un archivo
    if($file['error'] == 4){
        echo '<div class="'. $alerta .'">';
        echo '<h2>';
        echo 'Por favor seleccione un archivo PDF';
        echo '</h2>';
        echo '</div>';
    } else {

        // Verificar si el archivo es un PDF
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        if($fileType != "pdf"){
            echo '<div class="'. $alerta .'">' ;
            echo '<h2>';
            echo "Solo se permiten archivos PDF";
            echo '</h2>';
            echo '</div>';
        } else {
            // Configurar los detalles del archivo adjunto
            $fileName = $responsiva->tag.'-'. $responsiva->devuser .'.' . $fileType;
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];

            // Configurar la ruta y el nombre de archivo de destino
            $uploadDir = "c:/laragon/www/mv2/RESPONSIVAS/";
            
            $uploadFile = $uploadDir . $fileName;
            $responsiva->responsiva = $fileName;
            // Mover el archivo cargado al directorio de destino
            if(move_uploaded_file($fileTmpName, $uploadFile)){
                $alerta ="alerta-succes";
                echo '<div class="'. $alerta .'">' ;
                echo '<h2>';
                echo "El archivo " . $fileName . " se ha subido con éxito a la carpeta RESPONSIVAS.";
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