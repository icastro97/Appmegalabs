<?php
/**
 * Retorna lista de consentimientos.
 */
require 'database.php';

$cedula = $_GET['cedula'];

$documento = [];
if($cedula == "1110472429"){
    $sql = "SELECT DISTINCT T1.id_cliente, T1.Cliente, T2.cedula, T2.tratamientoDatos, T2.publicidad, T2.materialCientifico, T2.transferenciaValor, T2.adjunto, T2.adjuntoDos, T2.pdf, T3.cedula FROM `medicos` T1 LEFT JOIN resultadoCruce T3 on T1.id_cliente = T3.codigo LEFT JOIN formulario_firma T2 ON T2.cedula = T3.cedula";
    $result = mysqli_query($con,$sql);

}

else{
    $sql = "SELECT DISTINCT T1.id_cliente, T1.Cliente,T2.cedula, T2.tratamientoDatos, T2.publicidad, T2.materialCientifico, T2.transferenciaValor, T2.adjunto, T2.adjuntoDos, T2.pdf, T3.cedula FROM `medicos` T1 LEFT JOIN resultadoCruce T3 on T1.id_cliente = T3.codigo LEFT JOIN formulario_firma T2 ON T2.cedula = T3.cedula where T1.cedula_usuario = ".$cedula;
    $result = mysqli_query($con,$sql);

}

if($result)
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $documento[$i]['codigo']    = $row['id_cliente'];  
    $documento[$i]['nombre']    = $row['Cliente'];
    $documento[$i]['cedula']    = $row['cedula'];
    $documento[$i]['tratamiento'] = $row['tratamientoDatos'];
    $documento[$i]['publicidad'] = $row['publicidad'];
    $documento[$i]['material'] = $row['materialCientifico'];
    $documento[$i]['transferencia'] = $row['transferenciaValor'];
    $documento[$i]['adjunto'] = $row['adjunto'];
    $documento[$i]['adjuntoDos'] = $row['adjuntoDos'];
    $documento[$i]['pdf'] = $row['pdf'];
    $i++;
  }
  echo json_encode($documento);
}
else
{
  http_response_code(404);
}
