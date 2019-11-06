<?php

require_once '../../mcv5/clases/DB.class.php';


$cedula = $_REQUEST['cedula'];



    $sqlc = "SELECT  * FROM matrizaprobacion where cedulaSesion=". $cedula;
    
	$sql = mysqli_query($mysqli, $sqlc);
	if(!$sql)
	{
		var_dump(mysqli_error($mysqli));
	}

	$json = array();
	while($row = mysqli_fetch_array($sql))
	{
		$json[] = array(
			'modulo' => $row['modulo'],
			'aprobador' => $row['Aprobador'],
			'id' => $row['id_Aprobador'],
			'sesion' => $row['sesion'],
			'cedulaSesion' => $row['cedulaSesion']
		);
    }

	$jsonstring = json_encode($json);
	echo $jsonstring;


?> 