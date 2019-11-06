<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");

require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB


  
  // REALIZA LA QUERY A LA DB
  $sql="UPDATE `ped_cabeza` SET `observacion`='$_GET[observacion]' WHERE id_c = '$_GET[consec]'"; 
  $res=$con->query($sql);


$consulta = "UPDATE `ped_cabeza` SET `estado`='ENVIADO' WHERE id_c = '$_GET[consec]'";
 $query =$con->query($consulta);




  class Result {}
  if ($query === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'Se actualizo Correctamente';
} else {
  $response = new Result();
  $response->resultado='error';
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>