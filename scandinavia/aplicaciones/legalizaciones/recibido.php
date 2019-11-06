<?php

require_once '../../mcv5/clases/DB.class.php';

$recibido = $_POST['recibido'];
$rcid = $_REQUEST['rcid'];
$texto = "";
foreach($recibido as $key=>$value)
		{
			$hh = $value;
			$extrae =  $hh.",";	
		    $texto = $texto.$extrae;
		    
		}
		$texto  = substr ($texto, 0, strlen($texto) - 1);
        $sql="UPDATE lg_det_cabeza SET recibido = 'Si', fecharecibido = NOW() WHERE identificador IN (".$texto.")";
        $query = mysqli_query($mysqli, $sql);
        
        header('Location: http://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/verdocumentosg.php?id='.$rcid);
  
?>