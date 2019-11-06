<?php


require_once '../../mcv5/clases/DB.class.php';
$id = $_POST['transf'];
$factura = $_POST['factura'];
$fecha = $_POST['fecha'];
$nit = $_POST['nit'];
$nombre = $_POST['nombre'];
$tipoGasto = $_POST['tipoGasto'];
$base = $_POST['base'];
$iva = $_POST['iva'];
$user = $_POST['userSess'];
$radicado = $_POST['radicado'];
$consumo = $_POST['consumo'];
$moneda = $_POST['moneda'];
			//if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
			$file = $_FILES["archivo"];
			$nombreF = time() . $file["name"];
			$tipo = $file["type"];
			$ruta_provisional = $file["tmp_name"];
			$size = $file["size"];
			$dimensiones = 0;//getimagesize($ruta_provisional);
			$width = 0;//$dimensiones[0];
			$height = 0;//$dimensiones[1];
			$carpeta = "uploads/";
			$src = $carpeta . $nombreF;
			 move_uploaded_file($ruta_provisional, $src);
$descripcion = $_POST['descripcion'];




if(!empty($file["name"])){

$sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit',`establecimiento`='$nombre',`tipoFactura`='$tipoGasto',`descripcion`='$descripcion',`valorSinImpuesto`='$base',`valorImpuesto`='$iva',`valorIca`='$consumo',`fichero`='$nombreF', estado = '2', ultimoCambioEstado = NOW(), radicado = '$radicado', corregido = 'true', moneda = '$moneda' WHERE id_transferencia = '$id'";
//var_dump($sql);
 $ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`corregido`,`Observacion`) VALUES ('$id','$user','2',NOW(),'true','$descripcion')";
   $query = mysqli_query($mysqli, $consulta);
   //var_dump(mysqli_error($mysqli));
}

else{
    if($radicado != ''){
        
    
   $sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit',`establecimiento`='$nombre',`tipoFactura`='$tipoGasto',`descripcion`='$descripcion',`valorSinImpuesto`='$base',`valorImpuesto`='$iva',`valorIca`='$consumo' , estado = '2', ultimoCambioEstado = NOW(), radicado = '$radicado',corregido = 'true', moneda = '$moneda' WHERE id_transferencia = '$id'";
//var_dump($sql);
 $ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    }
    else{
   $sql = "UPDATE `transferencia_val` SET  `fecfact`= '$fecha',`factura`='$factura',`nit`='$nit',`establecimiento`='$nombre',`tipoFactura`='$tipoGasto',`descripcion`='$descripcion',`valorSinImpuesto`='$base',`valorImpuesto`='$iva',`valorIca`='$consumo' , estado = '2', ultimoCambioEstado = NOW(),corregido = 'true', radicado = NULL, moneda = '$moneda' WHERE id_transferencia = '$id'";
//var_dump($sql);
 $ejecucion = mysqli_query($mysqli, $sql);
 //var_dump(mysqli_error($mysqli));
    }
    $consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`corregido`,`Observacion`) VALUES ('$id','$user','2',NOW(),'true','$descripcion')";
 // var_dump($consulta);
 $query = mysqli_query($mysqli, $consulta); 
  //var_dump(mysqli_error($mysqli));
}
if($ejecucion)
{
    echo "<script>
           	        	    alert('Actualizacion correcta!');

            	
           	   window.location = 'https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/Listado/index.php?op=Listado';

            	
    </script>";

}
else
{
    
    
   echo "<script>
           	    alert('Fallo al actualizar');

            	
           	   window.location = 'https://appmegalabs.com/scandinavia/aplicaciones/transferencia/verdocumentos.php?documento='.$id;

            	
    </script>";
}




?>