<?php

require_once '../../mcv5/clases/DB.class.php';

$cedula = $_POST['cedulaMedico'];


	$consulta="SELECT DISTINCT codigo, cedula, tratamientoDatos, publicidad, materialCientifico, transferenciaValor FROM resultadoCruce WHERE cedula = ". $cedula."";
	
	$sql = mysqli_query($mysqli, $consulta);
	if(!$sql)
	{
		die('Query Error'. mysqli_error($mysqli));
	}

	$json = array();
	while($row = mysqli_fetch_array($sql))
	{
		$json[] = array(
			'codigo' => $row['codigo'],
			'cedula' => $row['cedula'],
			'tratamientoDatos' => $row['tratamientoDatos'],
			'publicidad' => $row['publicidad'],
			'materialCientifico' => $row['materialCientifico'],
			'transferenciaValor' => $row['transferenciaValor']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;


?>