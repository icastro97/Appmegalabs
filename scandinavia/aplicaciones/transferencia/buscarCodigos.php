<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id_factura'];
$result = '';

	 $consulta="SELECT facturaDeposito FROM `transferencia_val` WHERE id_transferencia =  $id ";
	 
	 $sql = mysqli_query($mysqli, $consulta);
     while ($row = mysqli_fetch_assoc($sql))
     {
        $facturaDeposito = $row['facturaDeposito'];
        
     }
     if($facturaDeposito == "true")
     {
        $consulta = "UPDATE transferencia_val SET tipoCodigo = null WHERE id_transferencia = ".$id;        
        $resultado = mysqli_query($mysqli,$consulta);
        $result = "si";
        echo  json_encode($result);

     }
     else
     {
        $consul = "SELECT tipo FROM codigos_transferencia where id_factura = ".$id; 
        $ejec = mysqli_query($mysqli, $consul);
        while($row = mysqli_fetch_array($ejec))
        {
            $tipo = $row['tipo'];
        }
        $consulta = "UPDATE transferencia_val SET tipoCodigo = '$tipo' WHERE id_transferencia = ".$id;        
        $resultado = mysqli_query($mysqli,$consulta);
        $result = "Mal";
        echo  json_encode($result);
     }

?> 
