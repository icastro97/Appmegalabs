<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
require("../precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

  //TRAEMOS LA SESION

require '../../../scandinavia/seguridad/config.php';

$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR

$productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

$documento = $_GET['rec'];


//var_dump($productosArray["saldo"]);


  $user = $_SESSION['user_id'];
  

$numero = rand();
  $documentoC = 'AN'.$numero;
  
  $sql ="INSERT INTO rc_data_update
  (Cliente_Especial,
  Tipo,
  DocOrig,
  Cliente,
  cod,
  OpeFecha,
  VtoFecha,
  Valor_original,
  Abono,
  Saldo,
  Valor_fact_antes_de_iva,
  Descuento_pp,
  Zona,
  Ciudad,
  Canal,
  Fechas_Vencimiento_segun_convenios,
  Fecha_Vencimiento_Plazo_Factura,
  Presupuesto_con_fechas_convenio,
  Presupuesto_con_fecha_factura,
  Presupuesto_Tesoreria,
  Presupuesto,
  Tipo3,
  Estado,
  En_presupuesto,
  Canal2,
  EstadoProceso,
  Observacion)
  VALUES
  ('',
  'AN',
  '$numero',
  '$_GET[cliente]',
  '$_GET[codigo]',
  NOW(),
  NOW(),
  $productosArray[saldo],
  0,
  $productosArray[saldo],
  0,
  0,
  'sin zona',
  'sin ciudad',
  'COMERCIAL',
  NOW(),
  NOW(),
  0,
  0,
  0,
  'NO',
  'Saldos',
  'Saldos',
  'No Presupuestado',
  'COMERCIAL',
  'ACT', 
  'Documento de Anticipo')
  ";
 // var_dump($sql);
  $query =$con->query($sql);
  
  
    $sqli = "INSERT INTO `rd_detalle`(`DocumentID`, Documento ,documentoOrigi, `ValorDocumento`) VALUES ($documento, '$documentoC' ,'$numero','$productosArray[saldo]')";
  // var_dump($sqli);
  $ejecutar=$con->query($sqli);

  class Result {}
  if ($ejecutar === TRUE) {
    $response = new Result();
    $response->resultado = 'OK';
    $response->mensaje = 'Registro Exitoso';

} else {
  $response = new Result();
  $response->resultado='error';
  $response->mensaje=mysqli_error($con);
    
}

  header('Content-Type: application/json');
  echo json_encode($response); // MUESTRA EL JSON GENERADO
?>