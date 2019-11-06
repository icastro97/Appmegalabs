<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['identificacion'];


if(!empty($id))
 {
	 $consulta="SELECT id_Aprobador, Aprobador FROM matrizaprobacion where cedulaSesion =". $id. " GROUP BY id_Aprobador";
	 
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'u_userid' => $row['id_Aprobador'],
			 'full_name' =>$row['Aprobador']
			 
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 }

?> 