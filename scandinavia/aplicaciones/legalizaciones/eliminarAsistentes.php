<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['asistencia'];
$legalizacionDetalle = $_POST['consecutivo'];


$sql = "DELETE FROM `asistencia` WHERE `id_asistencia` = " . $id;
$resultado = mysqli_query($mysqli, $sql);

if($resultado)
{
    $sqls = "SELECT nombreAsistente from asistencia where identificadordet = ". $legalizacionDetalle;
    $resultado1 =  mysqli_query($mysqli, $sqls);
    $numeros = mysqli_num_rows($resultado1);
    
    if ($numeros <= 0) {
        $sqly = "UPDATE lg_det_cabeza set asistencia = NULL where identificador = ". $legalizacionDetalle;
        $resultado2 =  mysqli_query($mysqli, $sqly);
        echo "true"; 
    }else {
        echo "true"; 
       }


 
  
}
else
{
    echo "false";
   
}

?>