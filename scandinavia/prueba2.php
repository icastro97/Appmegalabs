<?php
require_once("seguridad/config.php");
require('mcv5/clases/DB.class.php');

$grupo = $_POST['grupo'];
$usuario = $_POST['usuario'];
$checkAnt = $_POST['checkAnt'];
$checkLeg = $_POST['checkLeg'];


if ($grupo == "Anticipos" && $checkAnt == "true")
{
    $consulta = "UPDATE matrizaprobacion set respuesta = 0 WHERE modulo = 'Anticipos' and sesion = ". $usuario;   
    mysqli_query($mysqli, $consulta);

    header('Location: http://appmegalabs.com/scandinavia/default1.php?group=Anticipos');
} 
else if($grupo == "Legalizaciones" && $checkLeg == "true" )
{
    $consulta = "UPDATE matrizaprobacion set respuesta = 0 WHERE modulo = 'Legalizaciones' and sesion = ". $usuario;   
    mysqli_query($mysqli, $consulta);

    header('Location: http://appmegalabs.com/scandinavia/default1.php?group=Legalizaciones');
}

?>