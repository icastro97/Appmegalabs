
<?php
require_once '../../mcv5/clases/DB.class.php';

$ide = $_POST['id'];


	 $consulta="SELECT id, id_factura, codigoInversion, valor, tipo FROM codigoSi WHERE id_factura = '$ide'";
	 
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
 	}

 	$json = array();
 	while($row = mysqli_fetch_array($sql))
 	{
 		$json[] = array(
			 'id' => $row['id'],
			 'id_factura' => $row['id_factura'],
			 'codigo' => $row['codigoInversion'],
			 'porcentual' => $row['valor'],
			 'tipo' => $row['tipo'],

 		);
 	}
 	$jsonstring = json_encode($json);
 	echo $jsonstring;
 

?> 