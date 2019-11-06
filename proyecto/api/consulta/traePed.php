<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$ped = [];
$sql = "SELECT T1.id_c as consec, T1.cuentaCliente, T1.razonSocial, T1.nit, T1.region, T1.direccionEntrega, T1.vendedor, T1.procesado, T1.estado, sum(T2.precio) as subtotal FROM ped_cabeza T1 INNER JOIN ped_productos T2 ON T1.id_c = T2.consecutivo WHERE usuario = '$_GET[id]' group by T2.consecutivo";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['consec']    = $row['consec'];
    $ped[$i]['cuentaCliente'] = $row['cuentaCliente'];
    $ped[$i]['razonSocial'] = $row['razonSocial'];
    $ped[$i]['nit'] = $row['nit'];
    $ped[$i]['region'] = $row['region'];
    $ped[$i]['direccion']= $row['direccionEntrega'];
    $ped[$i]['vendedor'] = $row['vendedor'];
    $ped[$i]['procesado'] = $row['procesado'];
    $ped[$i]['estado'] = $row['estado'];
    $ped[$i]['subtotal'] = $row['subtotal'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>