<?php
/**
 * Retorna lista de consentimientos.
 */

 $maximoConsentimiento = $_GET['maximoConsentimiento'];
require 'database.php';



$documento = [];

$sql = "SELECT * FROM formulario_firma2 where id_consentimiento = ".$maximoConsentimiento;
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $documento[$i]['tratamientoDatos']    = $row['tratamientoDatos'];  
    $i++;
  }
  echo json_encode($documento);
}
else
{
  http_response_code(404);
}

