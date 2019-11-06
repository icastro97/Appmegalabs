<?php
/**
 * Retorna lista de clientes.
 */
require '../precios/database.php';
$ped = [];
$sql = "SELECT Cliente, NIT, id FROM vw_grillaclientesbasec GROUP BY NIT";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['id']    = $row['id'];
    $ped[$i]['cliente']    = $row['Cliente'];
    $ped[$i]['nit']    = $row['NIT'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  echo mysqli_error($con);
}

?>