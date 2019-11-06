<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  
 
 // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


  $consecutivo = $_GET['id'];


  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  $params = json_decode($json);

  // REALIZA LA QUERY A LA DB
  $sql="INSERT INTO `ped_productos`(`consecutivo`, `id_prod`, `codigo_prod`, `nombre`, `precio`, `principio`, `cantidad`) VALUES ('$consecutivo','$params->id','$params->codigo','$params->nombre','$params->precio','$params->principio','$params->cantidad')";

   $res=$con->query($sql);


  class Result {}
  if ($res === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'Registro Exitoso';
} else {
  $response = new Result();
  $response->resultado='error';
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>