<?php
/**
 * Retorna lista de clientes.
 */
require '../precios/database.php';
$ped = [];
$sql = "SELECT DocumentID,  razonsocial, Fecha, full_name, Aprobado, ValNeto, Rechazo FROM vw_recibostot ORDER BY DocumentID ASC";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['DocumentID']    = $row['DocumentID'];
    $ped[$i]['razonsocial']    = $row['razonsocial'];
    $ped[$i]['Fecha']    = $row['Fecha'];
    $ped[$i]['full_name']    = $row['full_name'];
    $ped[$i]['Aprobado']    = $row['Aprobado'];
    $ped[$i]['ValNeto']    = $row['ValNeto'];
    $ped[$i]['Rechazo']    = $row['Rechazo'];

    $i++;
  }
  echo json_encode($ped);
}
else
{
  echo mysqli_error($con);
}

?>