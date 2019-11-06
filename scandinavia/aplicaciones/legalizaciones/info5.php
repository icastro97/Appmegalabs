<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];


if(!empty($id))
 {
	 $consulta="SELECT cedula FROM system_users WHERE cedula = ". $id;
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'cedula' => $row['cedula'],
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 }

?> 
