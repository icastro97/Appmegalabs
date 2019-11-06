<?php
require_once '../../mcv5/clases/DB.class.php';

$Cinversion = $_POST['valor'];
$consecutivo = $_POST['consecutivo'];



$sql = "UPDATE transferencia_val set cinversion = '$Cinversion' WHERE id_transferencia = '$consecutivo'";

$ejecutar = mysqli_query($mysqli, $sql);

if ($ejecutar) {
    $response = "OK";
    echo $response;
}
else{
    $response = mysqli_error($sql);
    echo $response;
}


?>