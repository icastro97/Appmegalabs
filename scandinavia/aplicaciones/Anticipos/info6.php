<?php

require_once '../../mcv5/clases/DB.class.php';
$consecutivo = $_POST['consecutivo'];
$aprobador = $_POST['aprobador'];


    $consulta="UPDATE anticipo set aprobador = $aprobador where consecutivo = ".$consecutivo;         
     $sql = mysqli_query($mysqli, $consulta);
     if ($sql) 
     {
        echo "bien";
     } else {
        echo "mal";
     }
     
    
?> 


