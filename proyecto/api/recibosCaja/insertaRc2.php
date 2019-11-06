<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  //TRAEMOS LA SESION
require '../../../scandinavia/seguridad/config.php';

  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  $nit = $_GET['nit'];
  $recibo = $_GET['recibo'];

  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

 $i = 0;
  foreach ($productosArray as $row) {
      $documento = $row['Documento'];
      $origen = $row['DocOrig'];
      
      $sqli = "SELECT * FROM rd_detalle  where Documento = '$documento'";
      $query = $con->query($sqli);
      $filas = mysql_num_rows($query);
     // var_dump($filas);
   $sql="INSERT INTO `rd_detalle`(`DocumentID`, `Documento`, `documentoOrigi`) VALUES ('$recibo','$documento','$origen')";
  // var_dump($sql);
   $ejecucion=$con->query($sql);
   }

  class Result {}
  if ($filas > 0) 
  {
    $response = new Result();
    $response->resultado = 'duplicado';
    $response->mensaje = $recibo;

  } 

else
{
  $response = new Result();
  $response->resultado='OK';
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>