<?php
require_once '../../mcv5/clases/DB.class.php';

$nombreempleado = $_GET['nombreempleado'];


$consulta="SELECT cedula FROM empleadolg WHERE nombres LIKE '$nombreempleado'";

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