<?php

require('conexion.php');
require('consultas.php');


$nombrem = $_POST['nombrem'];
$codigos = $_POST['cod'];
$opcion = $_POST['opcion'];
$cedula = $_POST['cedula'];
$tratamiento = $_POST['tratamiento'];
$publicidad = $_POST['publicidad'];
$material = $_POST['material'];
$transferencia = $_POST['transferencia'];

  
        
if(!empty($nombrem) && !empty($codigos) && !empty($opcion) && !empty($cedula))
{
global $bd;

$sql = "INSERT INTO `cruce`(`codigo`, `nombrem`, `opcion`, `cedula`, `tratamientoDatos`, `publicidad`, `materialCientifico`, `transferenciaValor`, botonCruce) VALUES ('$codigos', '$nombrem', '$opcion', '$cedula', '$tratamiento','$publicidad', '$material', '$transferencia', '0')";
$ejecutar = mysqli_query($bd,$sql);

	echo "ok";

}
else
{
   
  	echo "no";
   
}


?>