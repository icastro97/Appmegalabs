<?php
require_once '../../mcv5/clases/DB.class.php';


if(isset($_FILES['files']['name']) )
{
    if(empty($_FILES['files']['name']) ) 
    {
        
        echo "<div class='alert alert-danger' role='alert'>    <h6>Por favor seleccione un archivo..</h6>   </div>";
                
    }
    else
    {
       
            $valorRandom = rand();
            $archivoCompleto = 'uploads/'.$valorRandom.$_FILES["files"]["name"];
            $id_factura = $_POST['transfer'];
            move_uploaded_file($_FILES["files"]["tmp_name"], $archivoCompleto);
            //echo 'File successfully uploaded :'. $archivoCompleto . '<br> ';
            $nombreArchivo = $_POST['nombreArchivo'];
            $tipoArchivo =  $_FILES["files"]["type"];
            $consulta = "INSERT INTO `archivos_facturas`(`id_factura`,nombreArchivo, `ruta_archivo`, `tipo_archivo`) VALUES ('$id_factura', '$nombreArchivo' , '$archivoCompleto','$tipoArchivo')";
            $res = mysqli_query($mysqli, $consulta);
            $consecutivo = mysqli_insert_id($mysqli);
            if($consecutivo > 0)
            {echo $consecutivo;}
       
    }
    
}

 

?>


 