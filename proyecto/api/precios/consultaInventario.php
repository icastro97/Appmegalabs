<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigoArticulo = $_GET['codigoArticulo'];

$ped = [];
$sql = "SELECT codigoArticulo, nombreArticulo, sum(fisicaDisponible) as fisicaDisponible,sum(fisicaReservada) as fisicaReservada, sum(inventarioFisico) as inventarioFisico FROM `saldosInventario` where codigoArticulo = '$codigoArticulo' and codigoDisposicion = 'ProntoVenc' GROUP BY codigoArticulo";
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $ped[$i]['codigoArticulo']    = $row['codigoArticulo'];
    $ped[$i]['nombreArticulo'] = $row['nombreArticulo'];
    $ped[$i]['inventarioFisico'] = $row['inventarioFisico'];
    $ped[$i]['fisicaReservada'] = $row['fisicaReservada'];
    $ped[$i]['fisicaDisponible'] = $row['fisicaDisponible'];
    $i++;
  }
  echo json_encode($ped);
}
else
{
  http_response_code(404);
}

?>