<?php

require_once '../../mcv5/clases/DB.class.php';

$codigo = $_POST['codigoMedico'];


	$consulta="SELECT adjunto, pdf FROM `formulario_firma` WHERE codigo = ". $codigo;
	
	$sql = mysqli_query($mysqli, $consulta);
	if(!$sql)
	{
		die('Query Error'. mysqli_error($mysqli));
	}

	$json = array();
	while($row = mysqli_fetch_array($sql))
	{
		$json[] = array(
			'adjunto' => $row['adjunto'],
			'pdf' => $row['pdf']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;


?>