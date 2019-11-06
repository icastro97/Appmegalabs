<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


  
  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  
  require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  
  $sql ="INSERT INTO `ped_cabeza`(id_c,`id_cliente`,`cuentaCliente`, `razonSocial`, `nit`, `region`, `direccionEntrega`, `vendedor`, fecha_registro, usuario, estado) VALUES (null,'$params->idcliente','$params->codigo','$params->nombre', '$params->nit', '$params->region', '$params->direccion', '$params->vendedor',NOW(),'$_GET[user]', 1)";

  // REALIZA LA QUERY A LA DB
  mysqli_query($con, $sql);  
  $var = mysqli_insert_id($con);
  class Result {}
  // GENERA LOS DATOS DE RESPUESTA
  $response = new Result();
  $response->resultado = 'OK';
  $response->mensaje = $var;
  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>