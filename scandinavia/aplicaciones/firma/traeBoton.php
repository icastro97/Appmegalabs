<?php

require_once '../../mcv5/clases/DB.class.php';

$cedula = $_POST['cedulaMedico'];


	$consulta="SELECT botonCruce FROM cruce WHERE cedula = ". $cedula;
	
	$sql = mysqli_query($mysqli, $consulta);
	if(!$sql)
	{
		die('Query Error'. mysqli_error($mysqli));
	
	}

	$json = array();
	while($row = mysqli_fetch_array($sql))
	{
		$json[] = array(
			'botonCruce' => $row['botonCruce']
		);
	}
	$jsonstring = json_encode($json);
	echo $jsonstring;


?>