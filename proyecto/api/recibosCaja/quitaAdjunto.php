<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';

$id = $_GET['id'];

  $user = $_SESSION['user_id'];
  $sqli = "DELETE FROM `rc_documentos` WHERE id = '$id'";
//var_dump($sqli);
  $ejecutar=$con->query($sqli);
   

  class Result {}
  if ($ejecutar === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'Registro Exitoso';

} else {
  $response = new Result();
  $response->resultado='error';
  $reponse->mensaje = mysqli_error($con);
  $response->mensaje=mysqli_error($con);
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>