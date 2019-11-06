<?php
/**
 * Retorna lista de consentimientos.
 */

$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
 
 $productosArray = json_decode($json, true); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

require 'database.php';



$documento = [];
foreach ($productosArray as $key) {
$sql = "select MAX(id_consentimiento) as maximoConsentimiento from formulario_firma2 where tipo2 = 'Ad' and codigo =".$key['codigo'];
$result = mysqli_query($con,$sql);

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $documento[$i]['maximoConsentimiento']    = $row['maximoConsentimiento'];  
    
  }
  echo json_encode($documento);
}
else
{
  http_response_code(404);
}
}
