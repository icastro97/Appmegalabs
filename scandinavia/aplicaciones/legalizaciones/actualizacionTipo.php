<?php


require_once '../../mcv5/clases/DB.class.php';

$tipolegalizacion = $_POST['tipolegalizacion'];
$consecutivo = $_POST['consecutivo'];


$sql = "UPDATE lg_cabeza SET tipoLegalizacion = '$tipolegalizacion' WHERE id_cabeza =".$consecutivo;
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