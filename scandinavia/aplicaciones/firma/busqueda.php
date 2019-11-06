<?php

require_once '../../mcv5/clases/DB.class.php';

$cedula = $_POST['cedula'];


	$consulta="SELECT * FROM formulario_firma where cedula = ".$cedula;
	$sql = mysqli_query($mysqli, $consulta);
    $numero = mysqli_num_rows($sql);
    if($numero >0)
    {
      echo "si";   
    }
    else
    {
        echo "no";   
    }
    


?>