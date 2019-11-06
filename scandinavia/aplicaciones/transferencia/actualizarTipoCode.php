<?php
require_once '../../mcv5/clases/DB.class.php';

$id_factura = $_POST['id_factura'];

$sql = "UPDATE transferencia_val set tipoCodigo = null , facturaDeposito = 'true'  WHERE id_transferencia = ".$id_factura;
$ejecutar = mysqli_query($mysqli, $sql);
if ($ejecutar == TRUE)
{ 
    echo "OK";
}
else
{
    echo "Fallo";
}


?>