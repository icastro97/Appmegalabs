<?php

function validacionpdf($consecutivo, $cedula)
{
    global $bd;
    $sqlx = "SELECT pdf FROM anticipo WHERE cedula=".$cedula;
    $consults = mysqli_query($bd, $sqlx);
    while ($fila = mysqli_fetch_array($consults)) 
    {
        $archivo = $fila['pdf'];
        if($archivo == null)
        {
            header('location: ajax-grid-antE.php');
        }
        else
        {
            global $bd;
            $query = "UPDATE anticipo SET estado = 1 WHERE consecutivo=".$consecutivo;
            $ejecutar=mysqli_query($bd, $query);
            header('Location: /scandinavia/aplicaciones/anticipo/listadoAnticipos.php?op=Listado Anticipos');	
        }
    }

}




?>