<?php


require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
$documento = $_GET['codigo'];
  $conexion = connect(); // CREA LA CONEXION
  $sql= "SELECT * FROM clientes where cuentacliente = '$documento'";
  //var_dump($sql);
  $registros = mysqli_query($conexion,$sql);
  $numero = mysqli_num_rows($registros);
//  var_dump($numero);
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