<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';

$clients = [];
$sql = "SELECT id, cuentacliente, NIT, razonsocial, region, direccionEntrega, vendedor FROM clientes WHERE institucional = 'Licitada' GROUP BY cuentacliente";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $clients[$i]['idcliente']    = $row['id'];
    $clients[$i]['codigo'] = $row['cuentacliente'];
    $clients[$i]['nit'] = $row['NIT'];
    $clients[$i]['nombre'] = $row['razonsocial'];
    $clients[$i]['region'] = $row['region'];
    $clients[$i]['direccion'] = $row['direccionEntrega'];
    $clients[$i]['vendedor'] = $row['vendedor'];
    $i++;
  }
  echo json_encode($clients);
}
else
{
  http_response_code(404);
}

