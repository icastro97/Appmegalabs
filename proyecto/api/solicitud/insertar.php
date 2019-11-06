<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

 //TRAEMOS LA SESION
 require 'conexion.php';

//$user = $_SESSION['user_id'];
  
  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  
  //var_dump($params);
  
  
  $sql ="INSERT INTO `matrizPrecios`(`codigo_axapta`, `nombre_comercial`, `precio_aprobado_x_presentac`, `codigoCliente`, `nombreCliente`)
  VALUES ('$params->codigoAxapta',  '$params->nombreComercial', '$params->precioAprobado', '$params->codigoCliente',  '$params->razonSocial' )";
 
  
  // REALIZA LA QUERY A LA DB
$EJECUTAR = mysqli_query($conn, $sql);  
  //$var = mysqli_insert_id($con);
   //$sqli ="INSERT INTO `historico_precios`(`codigo_axapta_afectado`, `usuario`, `fecha_cambio`) VALUES ('$params->codigo_axapta','$user',NOW())";
   //$ejecucion = mysqli_query($con, $sqli);  
  class Result {}
  // GENERA LOS DATOS DE RESPUESTA
 $response = new Result();
  $response->resultado = 'OK';
  $response->mensaje = $var;
  header('Content-Type: application/json');
 echo json_encode($response); // MUESTRA EL JSON GENERADO