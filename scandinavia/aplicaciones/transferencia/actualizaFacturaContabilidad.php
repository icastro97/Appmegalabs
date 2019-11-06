<?php


require_once '../../mcv5/clases/DB.class.php';
$id = $_POST['transf'];
$factura = $_POST['factura'];
$fecha = $_POST['fecha'];
$nit = $_POST['nit'];
$user = $_POST['userSess'];
$radicado = $_POST['radicado'];
$establecimiento = $_POST['establecimiento'];



if(!empty($file["name"])){

$sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit',`tipoFactura`='$tipoGasto', radicado = '$radicado', establecimiento = '$establecimiento' WHERE id_transferencia = '$id'";
//var_dump($sql);
 //$ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    //$consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`corregido`,`Observacion`) VALUES ('$id','$user','2',NOW(),'true','$descripcion')";
   $query = mysqli_query($mysqli, $consulta);
   //var_dump(mysqli_error($mysqli));
}

else{
    if($radicado != ''){
        
    
   $sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit', radicado = '$radicado', establecimiento = '$establecimiento' WHERE id_transferencia = '$id'";
//var_dump($sql);
 $ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    }
    else{
   $sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit',radicado = NULL,  establecimiento = '$establecimiento' WHERE id_transferencia = '$id'";
//var_dump($sql);
 $ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    }
   // $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`corregido`,`Observacion`) VALUES ('$id','$user','2',NOW(),'true','$descripcion')";
 // var_dump($consulta);
 //$query = mysqli_query($mysqli, $consulta); 
  //var_dump(mysqli_error($mysqli));
}
if($ejecucion)
{
    
           		    

            	
           	   header("Location:https://appmegalabs.com/scandinavia/aplicaciones/transferencia/verDocumentosCs.php?documento=$id");

            	
    

}
else
{
    
    
   header("Location:https://appmegalabs.com/scandinavia/aplicaciones/transferencia/verDocumentosCs.php?documento=$id");
}




?>