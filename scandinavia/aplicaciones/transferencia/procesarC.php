<?php
require_once '../../mcv5/clases/DB.class.php';

$estado = $_POST['estado'];
$observacion = $_POST['observacion'];
$id = $_POST['id'];
$numApr = $_POST['numApr'];


$sql = "UPDATE transferencia_val SET tipoApr = '$estado', proceContabilidad = '$observacion', aprContabilidad = '$numApr', ultimoCambioEstado = NOW() WHERE id_transferencia = ".$id;
$ejecutar = mysqli_query($mysqli, $sql);


if ($ejecutar == TRUE)
{ 
       $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id','$user','$estado',NOW(),'$observacion')";
    $ejecutar = mysqli_query($mysqli, $consulta);
    if($ejecutar == TRUE){
     echo "exito";
}
else{
    echo "error";
}
}
else
{
    echo "Fallo";
}




?>