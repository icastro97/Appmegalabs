<?php

require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  $conexion = connect(); // CREA LA CONEXION
  // REALIZA LA QUERY A LA DB
  $codigo = $_GET['codigo'];
  $cliente = $_GET['cliente'];
  $precio = $_GET['precio']; 
  $sql= "SELECT * FROM `matrizPrecios` WHERE codigoCliente LIKE '%$cliente%' AND codigo_axapta = '$codigo' AND  precio_aprobado_x_presentac = '$precio'";
  //var_dump($sql);
  $registros = mysqli_query($conexion,$sql);
  $numero = mysqli_num_rows($registros);
   if ($numero > 0)  
  {
    $datos = "Exito";
  }
  else
  {
    
      $datos = "mal";
  }
  
  $json = json_encode($datos); // GENERA EL JSON CON LOS DATOS OBTENIDOS
  echo $json; // MUESTRA EL JSON GENERADO

  
?>