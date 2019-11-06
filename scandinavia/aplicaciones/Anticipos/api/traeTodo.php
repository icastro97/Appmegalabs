<?php
/**
 * Retorna lista de clientes.
 */
require '../../../../proyecto/api/consulta/database.php';

$aprobador = $_GET['aprobador'];
$cedula = $_GET['cedula'];
$user = $_GET['user'];

$anticipo = [];
$sql = "SELECT T1.consecutivo, T1.tipo, T1.fechaActual, T1.identificacion, T1.nombre, T1.estado, T1.aprobador
FROM anticipo T1 INNER JOIN system_users T2 WHERE IF( T1.estado = '0', '', T1.aprobador = '$aprobador' OR T1.identificacion = '$cedula' OR T1.userid = '$user' ) 
GROUP BY T1.consecutivo order by T1.estado ";

$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $anticipo[$i]['numero']    = $row['consecutivo'];  
    $anticipo[$i]['tipo']    = $row['tipo'];
    $anticipo[$i]['fecha'] = $row['fechaActual'];
    $anticipo[$i]['identificacion'] = $row['identificacion'];
    $anticipo[$i]['nombre'] = $row['nombre'];
    $anticipo[$i]['estado'] = $row['estado'];
    $anticipo[$i]['aprobador'] = $row['aprobador'];
    $i++;
  }
  echo json_encode($anticipo);
}
else
{
 http_response_code(404);
}
?>