<?php
require_once '../../mcv5/clases/DB.class.php';

$ide = $_POST['ide'];
$lgcabeza = $_POST['lgcabeza'];



	 $consulta="SELECT id_asistencia, tipo, cantidad, nombreAsistente, cedulaAsistente, identificadorlg, identificadordet, transferenciaValor FROM asistencia LEFT JOIN resultadoCruce T2 ON T2.cedula = cedulaAsistente WHERE identificadordet = '$ide' AND identificadorlg ='$lgcabeza'";
	 //var_dump($consulta);
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}
 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'id_asistencia' => $row['id_asistencia'],
			 'tipo' => $row['tipo'],
			 'cantidad' => $row['cantidad'],
			 'nombreAsistente' => $row['nombreAsistente'],
			 'cedulaAsistente' => $row['cedulaAsistente'],			 
			 'legalizacion' => $row['identificadorlg'],
			 'consecutivo' => $row['identificadordet'],
			 'transferenciaValor' => $row['transferenciaValor']
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
?> 