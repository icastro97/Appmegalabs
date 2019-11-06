<?php

require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  $conexion = connect(); // CREA LA CONEXION
  // REALIZA LA QUERY A LA DB
  $registros = mysqli_query($conexion, "SELECT `codigo`,`Precio_Regulado_Circular_7_de_2018_presentacion` FROM `precios_Regulacion` WHERE codigo = '$_GET[codigo]'");
 
  // SI EL USUARIO EXISTE OBTIENE LOS DATOS Y LOS GUARDA EN UN ARRAY
  if ($resultado = mysqli_fetch_array($registros))  
  {
    $datos = $resultado;
  }
  
  $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
  echo $json; // MUESTRA EL JSON GENERADO
  
?>