<?php
//reporteUbicaciones


function insertarDatos($tipo, $nombreAsistente, $cedulaAsistente,$id, $valor)
{
    global $bd;
    
    $consulta2 = "INSERT INTO asistencia_trans_valor (`tipo`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor) VALUES ('$tipo' ,'$nombreAsistente','$cedulaAsistente','$id', '$valor')";
    
    $result2 = mysqli_query($bd, $consulta2);


    $sql = "UPDATE transferencia_val SET asistencia = '1' where id_transferencia =".$id;
    $resultado = mysqli_query($bd, $sql);


    
    echo "<script languaje='javascript' type='text/javascript'>setTimeout('window.close()',1000)</script>";
}

function eliminar($id)
{
    global $bd;
        
    $eliminar = "DELETE  FROM asistencia_trans_valor WHERE identificadordet = ".$id;    
    $ejecucion = mysqli_query($bd, $eliminar);
}





?>