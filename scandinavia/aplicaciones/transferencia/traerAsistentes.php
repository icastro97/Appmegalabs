<?php
require_once '../../mcv5/clases/DB.class.php';

$ide = $_POST['id'];


	 $consulta="SELECT DISTINCT `id_asistenciaTrans`, `tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor, T2.transferenciaValor FROM asistencia_trans_valor T1 LEFT JOIN resultadoCruce T2 ON T2.cedula = T1.cedulaAsistente WHERE T1.identificadordet = '$ide' LIMIT 12";
	 $sql = mysqli_query($mysqli, $consulta);

 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 	
 	$json[] = array(
			 'id_asistencia' =>  $row['id'],
			  'tipo' =>$row['tipo'],
			     'cantidad' => $row['cantidad'],
			  'nombreAsistente' => $row['nombreAsistente'],
			  'cedulaAsistente' => $row['cedulaAsistente'],
			  'identificadordet' => $row['identificadordet'],
			 'valor' => $row['valor'],
			 'transferenciaValor' => $row['transferenciaValor']
	);
	
	
 		
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 	
 

?> 
