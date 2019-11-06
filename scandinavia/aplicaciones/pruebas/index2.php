<?php
require('conexion.php');
require('functions.php');

$cedula = $_POST['cedula'];
$imagen = $_POST['imagen'];

$insertar = insertarDatos($cedula, $imagen);
$carga = cargarImagen($cedula, $imagen);

echo "Se ejecuto";



?>