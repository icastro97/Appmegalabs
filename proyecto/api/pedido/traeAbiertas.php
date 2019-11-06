<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$products = [];
$sql = "SELECT T1.id_c, T1.cuentaCliente, T1.razonSocial, T1.nit, T1.region, T1.direccionEntrega, T1.vendedor, T1.estado, T1.ordenCompra FROM ped_cabeza T1
 INNER JOIN ped_productos T2 ON T1.id_c = T2.consecutivo WHERE T1.estado = '1' AND T1.usuario = '$_GET[user]' GROUP BY id_c";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $products[$i]['id']    = $row['id_c'];  
    $products[$i]['codigo']    = $row['cuentaCliente'];
    $products[$i]['nombre'] = $row['razonSocial'];
    $products[$i]['nit'] = $row['nit'];
    $products[$i]['region'] = $row['region'];
    $products[$i]['direccion'] = $row['direccionEntrega'];
    $products[$i]['vendedor'] = $row['vendedor'];
    $products[$i]['estado'] = $row['estado'];
    $products[$i]['orden'] = $row['ordenCompra'];
    $i++;
  }
  echo json_encode($products);
}
else
{
  http_response_code(404);
}
