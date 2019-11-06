<?php
require_once '../../mcv5/clases/DB.class.php';
require_once("../../seguridad/config.php");

$id_factura = $_POST['id_factura'];
$test = $_POST['test1'];
$user = $_SESSION['user_id'];

$sql = "UPDATE transferencia_val set novedadFacturaDespues =  '$test'  WHERE id_transferencia = ".$id_factura;

$ejecutar = mysqli_query($mysqli, $sql);

    $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$id_factura','$user','REVC',NOW(),'$test')";
    $ejecucion = mysqli_query($mysqli, $consulta);
    
if ($ejecutar == TRUE)
{ 
    echo "OK";
}
else
{
    echo "Fallo";
}


?>