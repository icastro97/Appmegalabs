<?php

require_once '../../mcv5/clases/DB.class.php';
require_once("../../seguridad/config.php");


$id = $_POST['id'];
$user = $_SESSION['user_id'];
$descripcion= $_POST['obs'];

$sql = "UPDATE transferencia_val SET estado = 'APR' WHERE id_transferencia = '$id'";
$resultado = mysqli_query($mysqli, $sql);

if($resultado == TRUE)
{
    $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id','$user','APR',NOW(),'$descripcion')";
    $ejecutar = mysqli_query($mysqli, $consulta);
    
    echo "Exito";

}

else
{
    echo mysqli_error($mysqli);
   
}

?>