<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigo = $_GET['codigo'];
$ped = [];
$sql = "SELECT `Codigo_de_articulo`, `Nombre_del_articulo` , ISO_Key FROM `maestroProductos` WHERE  Codigo_de_articulo LIKE '%$codigo%' GROUP BY Codigo_de_articulo";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_array($result))
  {
    $ped[$i]['nombre_comercial']    = $row['Nombre_del_articulo'];
    $ped[$i]['principio']    = $row['ISO_Key'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>