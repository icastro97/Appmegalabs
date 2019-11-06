<?php
require_once '../../mcv5/clases/DB.class.php';

$nombre = $_GET['equipo'];
utf8_encode($nombre);

$consulta="SELECT id_cliente FROM medicos WHERE Cliente LIKE '$nombre'";
$sql = mysqli_query($mysqli, $consulta);
  

if(mysqli_num_rows($sql) > 0)
{
    $row = mysqli_fetch_object($sql);
    $row ->status = 200;
    echo json_encode($row);
}
else{
    $error = array('status' => 400);
    echo json_encode((object)$error);
}
?>