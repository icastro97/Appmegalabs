<?php
/**
 * Retorna lista de clientes.
 */
require 'database.php';
$codigo = $_GET['criterio'];
$ped = [];
class Result {}
$sql = "SELECT `codigo_axapta` FROM `matrizPrecios` WHERE `codigo_axapta` LIKE '%$codigo%' GROUP BY codigo_axapta";
$result = mysqli_query($con,$sql);

if($result)
{
$i = 0;
  while($row = mysqli_fetch_array($result))
  {
    $ped[$i]['Search'] = $row['codigo_axapta'];
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