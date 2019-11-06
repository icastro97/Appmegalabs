<?php
require_once '../../mcv5/clases/DB.class.php';

$user = $_POST['user'];

	 $consulta="SELECT * FROM transferencia_val WHERE user_id = $user ORDER by id_transferencia DESC LIMIT 1 ";
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'fecfact' => $row['fecfact'],
			 'nit' => $row['nit'],
			 'establecimiento' => $row['establecimiento'],
			 'tipoFactura' => $row['tipoFactura'],
			 'descripcion' => $row['descripcion']
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 