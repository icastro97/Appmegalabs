<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$ped = [];
$sql = "SELECT id_c as consec, cuentaCliente, razonSocial, nit,ordenCompra, region, direccionEntrega, vendedor, procesado, estado  FROM ped_cabeza WHERE estado in ('ENVIADO', 'ACEPTADO') ORDER BY procesado = true";
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
    $ped[$i]['orden'] = $row['ordenCompra'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>