<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['asistencia'];
$legalizacionDetalle = $_POST['consecutivo'];


$sql = "DELETE FROM `asistencia_trans_valor` WHERE `id_asistenciaTrans`=". $id;
$resultado = mysqli_query($mysqli, $sql);

if($resultado)
{
    $sqls = "SELECT nombreAsistente from asistencia_trans_valor  where identificadordet = ".$legalizacionDetalle;

    $resultado1 =  mysqli_query($mysqli, $sqls);
    $numeros = mysqli_num_rows($resultado1);

    if ($numeros <= 0)
    {
        $sqly = "UPDATE transferencia_val set asistencia = NULL where id_transferencia = ".$legalizacionDetalle;
        $resultado2 =  mysqli_query($mysqli, $sqly);
        echo "true"; 
    }
    else
    {
        echo "true"; 
    }
}

else
{
    echo mysqli_error($mysqli);
   
}

?>