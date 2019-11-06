<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  
 
  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
$var=$_GET[archivo];

  $consulta ="UPDATE `ped_cabeza` SET `estado`= 'ENVIADO' WHERE id_c = '$_GET[consec]'";
   $querty = mysqli_query($con, $consulta);  

  $sql = "UPDATE `ped_cabeza` SET `observacion`='$_GET[obser]' WHERE id_c = '$_GET[consec]'";
   $res = mysqli_query($con,$sql);



  class Result {}
  if ($querty === TRUE) {
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