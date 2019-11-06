<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigo = $_GET['criterio'];
$ped = [];
class Result {}
$sql = "SELECT `nombre_comercial` FROM `matrizPrecios` WHERE `nombre_comercial` LIKE '%$codigo%' GROUP BY `nombre_comercial`";
$result = mysqli_query($con,$sql);

if($result)
{
$i = 0;
  while($row = mysqli_fetch_array($result))
  {
    $ped[$i]['Search'] = $row['nombre_comercial'];
    $i++;
  }
          // GENERA LOS DATOS DE RESPUESTA
        $response = new Result();
        $response->Search = $ped;

}
else
{
  http_response_code(404);
            $response = new Result();
            $response->Error = 'Error';
}




        header('Content-Type: application/json');
        echo json_encode($response); // MUESTRA EL JSON GENERADO
?>