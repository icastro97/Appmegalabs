<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

 //TRAEMOS LA SESION
 require '../../../scandinavia/seguridad/config.php';

$user = $_SESSION['user_id'];
  
  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  
  $sql ="INSERT INTO `matrizPrecios`(`codigo_axapta`, `nombre_comercial`, `principio`, `contenido`, `precio_aprobado_x_umc`, `precio_aprobado_x_presentac`, `codigoCliente`, `nombreCliente`, `vigenciaDesde`,`vigenciaHasta`, `convenio`, `opcion`, `comentarios`, `tipo`)
  VALUES ('$params->codigo_axapta',
  '$params->nombre_comercial',
  '$params->principio',
  '$params->contenido',
  '$params->precio_aprobado_x_umc',
  '$params->precio_aprobado_x_presentac'
  ,'$params->codigoCliente',
  '$params->nombreCliente',
  '$params->vigenciaDesde',
  '$params->vigenciaHasta',
  '$params->convenio',
  '$params->opcion',
  '$params->comentarios',
  'plataforma'
  )";
 
  
  // REALIZA LA QUERY A LA DB
$EJECUTAR = mysqli_query($con, $sql);  
  $var = mysqli_insert_id($con);
   $sqli ="INSERT INTO `historico_precios`(`codigo_axapta_afectado`, `usuario`, `fecha_cambio`) VALUES ('$params->codigo_axapta','$user',NOW())";
   $ejecucion = mysqli_query($con, $sqli);  
  class Result {}
  // GENERA LOS DATOS DE RESPUESTA
 $response = new Result();
  $response->resultado = 'OK';
  $response->mensaje = $var;
  header('Content-Type: application/json');
 echo json_encode($response); // MUESTRA EL JSON GENERADO