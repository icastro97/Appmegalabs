<?php
//reporteUbicaciones


function insertarDatos($codigo, $porcentaje,$id)
{
    global $bd;
  
        $consulta2 = "INSERT INTO `codigosinversion`( `codigoInversion`, `id_factura`, `porcentual`) VALUES ('$codigo','$id','$porcentaje')";    
        $result2 = mysqli_query($bd, $consulta2);
        
        echo "<script languaje='javascript' type='text/javascript'>setTimeout('window.close()',1000)</script>";
 

    
    
    
}


function eliminar($id)
{
    global $bd;
        
    $eliminar = "DELETE  FROM codigosinversion WHERE id_factura = ".$id;    
    $ejecucion = mysqli_query($bd, $eliminar);
}



?>