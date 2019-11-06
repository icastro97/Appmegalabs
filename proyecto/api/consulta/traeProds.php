<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$products = [];
$sql = "SELECT `consecutivo`, `nombre`, `precio`, `principio`, `cantidad`, `bonificadas` FROM `ped_productos` WHERE consecutivo = '$_GET[consec]'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['consec']    = $row['consecutivo'];  
    $products[$i]['nombre']    = $row['nombre'];
    $products[$i]['precio'] = $row['precio'];
    $products[$i]['principio'] = $row['principio'];
    $products[$i]['cantidad'] = $row['cantidad'];
    $products[$i]['bonificadas'] = $row['bonificadas'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>