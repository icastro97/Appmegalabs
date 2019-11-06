<?php


require_once '../../mcv5/clases/DB.class.php';

$observaciones = $_POST['observaciones'];
$consecutivo = $_POST['consecutivo'];


$sql = "UPDATE lg_cabeza SET observaciones = '$observaciones' WHERE id_cabeza =".$consecutivo;
$ejecucion = mysqli_query($mysqli, $sql);

if($ejecucion)
{
    $var = "Ok";
    echo $var;
}
else
{
    $var = "Paila";
    echo $var;
}




?>