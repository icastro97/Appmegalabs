<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';

  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  $user = $_SESSION['user_id'];
  $nit = $_GET['nit'];
  $sqli = "INSERT INTO rc_cabeza(`Cliente`, `usuario`) VALUES ('$nit', '01')";//importante porfavor ingresar en vez de el 1 la variable de sesion
  $ejecutar=$con->query($sqli);
  
  $UltimoId = mysqli_insert_id($con);

  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

 $i = 0;
  foreach ($productosArray as $row) {
      $documento = $row['Documento'];
      $origen = $row['DocOrig'];
   $sql="INSERT INTO `rd_detalle`(`DocumentID`, `Documento`, `documentoOrigi`) VALUES ('$UltimoId','$documento','$origen')";
   //var_dump($sql);
   $ejecucion=$con->query($sql);
   }

  class Result {}
  if ($ejecutar === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = $UltimoId;

} else {
  $response = new Result();
  $response->resultado='error';
  $reponse->mensaje = mysqli_error($con);
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>