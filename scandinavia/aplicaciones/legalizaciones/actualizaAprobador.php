<?php


require_once '../../mcv5/clases/DB.class.php';

$aprobador = $_POST['listaapr1'];
$consecutivo = $_POST['consecutivo'];


$sql = "UPDATE lg_cabeza SET aprobador = '$aprobador' WHERE id_cabeza =".$consecutivo;
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