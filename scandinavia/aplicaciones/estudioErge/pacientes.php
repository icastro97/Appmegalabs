<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['cedulaMedico'];


if(!empty($id))
 {
	 $consulta="SELECT codigoPaciente FROM pacientes WHERE habilitado = 1 and estudio = 'EPI-ERGE' and cedulaMedico =".$id;
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
 			'codigoPaciente' => $row['codigoPaciente']
 			
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 }

?> 
