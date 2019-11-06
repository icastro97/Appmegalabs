<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

 //TRAEMOS LA SESION
 require '../../../scandinavia/seguridad/config.php';

$user = $_SESSION['user_id'];
  
  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR

  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  //  var_dump($params->nit);  
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  
  $sql ="INSERT INTO `clientes`(`NIT`, `cuentacliente`, `razonsocial`, `grupoventas`, `condicionpago`, `zona`, `region`, `vendedor`, `direccionEntrega`, `institucional`)
  VALUES (
  '$params->nit',
  '$params->cuentaCliente',
  '$params->razonSocial',
  '$params->grupoVentas',
  '$params->condicionPago',
  '$params->zona'
  ,'$params->region',
  '$params->vendedor',
  '$params->direccion',
  '$params->institucional'
  )";
  // REALIZA LA QUERY A LA DB
$EJECUTAR = mysqli_query($con, $sql);  
 
  class Result {}
 if($EJECUTAR){
       // GENERA LOS DATOS DE RESPUESTA
 $response = new Result();
  $response->resultado = 'OK';
 }
 else{
       // GENERA LOS DATOS DE RESPUESTA
 $response = new Result();
  $response->resultado = 'mal';
 }

  header('Content-Type: application/json');
 echo json_encode($response); // MUESTRA EL JSON GENERADO