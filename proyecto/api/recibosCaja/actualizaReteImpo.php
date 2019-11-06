<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';
$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR

$documento = $_GET['id'];
$ID = $_GET['doc'];
$neto = $_GET['neto'];

  $user = $_SESSION['user_id'];
  $sqli = "UPDATE `rd_detalle` SET `RetImpositiva`= $json WHERE Documento = '$documento' AND DocumentID = '$ID'";
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