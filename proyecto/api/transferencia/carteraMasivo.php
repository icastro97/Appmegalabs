<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");


  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  
 $obser = $_GET['obs'];
  $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  require '../../../scandinavia/seguridad/config.php';
    
  $user = $_SESSION['user_id'];
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  foreach ($productosArray as $row) {
   
  $id = $row["id"];  
   
$sql = "UPDATE transferencia_val SET estado  = 'EN CARTERA', observacionRevision = '$obser' , ultimoCambioEstado = NOW() WHERE id_transferencia = '$row[id]'";
$query = mysqli_query($con, $sql);
if($query == TRUE)
{
   $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$row[id]','$user','EN CARTERA',NOW(),'$obser')";
    $ejecutar = mysqli_query($con, $consulta);
  
}
else
{
    var_dump(mysqli_error($con));
    echo "error";
}
}
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