<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$products = [];
$sql = "SELECT T1.id ,T1.consecutivo,T1.nombre, T1.precio, T1.principio, T1.cantidad, T2.observacion, T2.ordenCompra, T2.FechaOrden, T2.nombreArchivo FROM `ped_productos` T1 INNER JOIN ped_cabeza T2 on T1.consecutivo = T2.id_c WHERE consecutivo = '$_GET[consec]'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id'];  
    $products[$i]['consec']    = $row['consecutivo'];  
    $products[$i]['nombre']    = $row['nombre'];
    $products[$i]['precio'] = $row['precio'];
    $products[$i]['principio'] = $row['principio'];
    $products[$i]['cantidad'] = $row['cantidad'];
    $products[$i]['observacion'] = $row['observacion'];
    $products[$i]['ordenCompra'] = $row['ordenCompra'];
    $products[$i]['FechaOrden'] = $row['FechaOrden'];
    $products[$i]['nombreArchivo'] = $row['nombreArchivo'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}

?>