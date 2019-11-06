<?php

require_once '../../mcv5/clases/DB.class.php';

$cedula = $_POST['x'];



	 $consulta="SELECT cedula,nombremedico from formulario_firma where cedula = ".$cedula;
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
             'nombremedico' => $row['nombremedico'],
             'cedula' => $row['cedula']
 			
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 