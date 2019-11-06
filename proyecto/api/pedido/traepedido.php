<?php
/**
 * Retorna lista de clientes.
 */
$id = $_GET['id'];
require 'database.php';

$products = [];
$sql = "SELECT `id`, `consecutivo`, `id_prod`, `codigo_prod`, `nombre`, `precio`, `principio`, `cantidad`,`bonificadas` FROM `ped_productos` WHERE consecutivo = '$id'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id'] = $row['id'];
    $products[$i]['consecutivo'] = $row['consec']; 
    $products[$i]['codigo']    = $row['codigo_prod'];
    $products[$i]['nombre'] = $row['nombre'];
    $products[$i]['principio'] = $row['principio'];
    $products[$i]['cantidad'] = $row['cantidad'];
    $products[$i]['precio'] = $row['precio'];
    $products[$i]['bonificadas'] = $row['bonificadas'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}