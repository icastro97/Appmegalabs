<?php

require_once '../../mcv5/clases/DB.class.php';

$fechaDesembolso = $_POST['fechaDesembolso'];
$id_anticipo = $_POST['id_anticipo'];


	 $consulta="UPDATE anticipo SET fechadesembolso = '$fechaDesembolso' WHERE id_anticipo =".$id_anticipo;
	 $sql = mysqli_query($mysqli, $consulta);
	 
 	if(!$sql)
 	{
 		die(mysqli_error($mysqli));
     }
     else
     {
         echo "Actualizado";
     }

 	
 

?> 
