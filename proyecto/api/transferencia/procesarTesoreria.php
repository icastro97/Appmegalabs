<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  
 
  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  require '../../../scandinavia/seguridad/config.php';

  $user = $_SESSION['user_id'];
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  $obs = $_GET['observacion'];
  foreach ($productosArray as $row) {
   
  $consec = $row["id"];  
  $estado = $row["estado"];

 
      
  // REALIZA LA QUERY A LA DB
  $sql="UPDATE `transferencia_val` SET `estado`= 'PAGADO', observacionTesoreria = '$obs' WHERE id_transferencia= $consec"; 
  $res=$con->query($sql);

  $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio, Observacion) VALUES ('$consec', '$user', 'PAGADO', NOW(),'$obs')";
  $query=$con->query($consulta);

  
}

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