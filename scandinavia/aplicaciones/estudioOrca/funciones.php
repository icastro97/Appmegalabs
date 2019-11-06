<?php

 $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
 mysqli_set_charset($bd,'utf8');

function insertarDatos($siI, $estudio, $fechaActual, $nombreMedico, $ciudad, $codigoPaciente, $noI, $siE, $noE, $fem, $mas, $peso, $talla, $sistolica, $diastolica, $siro, $noro, $sica, $noca, $siman, $noman, $noH, $siH, $descripcion)
{
    global $bd;
    $sql= "INSERT INTO `formularios`(`siI`, `estudio`, `fechaActual`, `nombreMedico`, `ciudad`, `codigoPaciente`, `noI`, `siE`, `noE`, `fem`, `mas`, `peso`, `talla`, `sistolica`, `diastolica`, `siro`, `noro`, `sica`, `noca`, `siman`, `noman`, `noH`, `siH`, `descripcion`) VALUES ('$siI', '$estudio', '$fechaActual', '$nombreMedico', '$ciudad', '$codigoPaciente', '$noI', '$siE', '$noE','$fem', '$mas','$peso', '$talla', '$sistolica', '$diastolica','$siro','$noro','$sica', '$noca', '$siman', '$noman', '$noH', '$siH','$descripcion')";
    $query = mysqli_query($bd, $sql);
    return $query;
    
}   


?>
