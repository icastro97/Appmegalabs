<?php
//reporteUbicaciones

require_once ("conexionAsistentes.php");

function insertarDatos($tipo, $nombreAsistente, $cedulaAsistente,$id, $lg)
{
    
    global $bd;

    $consulta2 = "INSERT INTO asistencia (tipo, nombreAsistente, cedulaAsistente, identificadorlg, identificadordet) VALUES ('$tipo', '$nombreAsistente','$cedulaAsistente','$lg','$id')";
    $result2 = mysqli_query($bd, $consulta2);
    
    $sql = "UPDATE lg_det_cabeza SET asistencia = '1' where identificador =".$id;
    $resultado = mysqli_query($bd, $sql);


    echo" <script>setTimeout('window.close()',1000)</script>";

    
    

    
   
}






?>