<?php
require_once '../../mcv5/clases/DB.class.php';

$codigo = $_POST['conversion'];





     $consulta="SELECT tipo, cod FROM conceptos_transvalor where cod =". $codigo;
     
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
             'tipo' => $row['tipo'],
             'codigo' => $row['cod'],
 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 
