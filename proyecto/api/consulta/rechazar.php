<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  
 
  
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

  // REALIZA LA QUERY A LA DB
  $sql="UPDATE `ped_cabeza` SET `estado`= '1',  `observacionRechazo` = '$_GET[observacion]' WHERE id_c= '$_GET[id]'"; 
  $res=$con->query($sql);


  class Result {}
  if ($res === TRUE) {
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