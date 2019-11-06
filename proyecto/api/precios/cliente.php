<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigo = $_GET['codigo'];
$ped = [];
$sql = "SELECT`cuentacliente`, `razonsocial` FROM `clientes` WHERE `cuentacliente` LIKE '%$codigo%'";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['codigo']    = $row['cuentacliente'];
    $ped[$i]['nombre']    = $row['razonsocial'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>