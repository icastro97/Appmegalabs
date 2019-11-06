<?php

require_once '../../mcv5/clases/DB.class.php';

$codigo = $_POST['codigom'];


	$consulta="SELECT * FROM `resultadoCruce` WHERE codigo = ". $codigo;
	
	$sql = mysqli_query($mysqli, $consulta);
	$num = mysqli_num_rows($sql);
	if($num > 0)
	{
	    echo "ok";
	}
	else
	{
	   echo "no"; 
	}


?>