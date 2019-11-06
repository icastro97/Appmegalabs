<?php
require_once '../../mcv5/clases/DB.class.php';

$radicado = $_POST['radicado'];


	 $consulta="SELECT radicado FROM transferencia_val WHERE radicado = '$radicado'";
	 $sql = mysqli_query($mysqli, $consulta);
	 $numeroConsulta = mysqli_num_rows($sql);
	 
 	if($numeroConsulta > 0)
 	{
 		echo true;
 	}
    else
    {
        echo false;
    }
 	
 	
 

?> 