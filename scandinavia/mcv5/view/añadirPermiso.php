<?php

require_once '../../mcv5/clases/DB.class.php';

if(isset($_POST['modulos']))
{
    $modulos = $_POST['modulos'];
    $nombre = $_POST['persona'];
    $id = $_POST['id'];
    $sesion = $_POST['sesion'];
    $cedulaSesion = $_POST['cedulaSesion'];
    $sql ="INSERT INTO matrizaprobacion (modulo, aprobador, id_Aprobador, sesion, cedulaSesion) VALUES ('$modulos', '$nombre', '$id', '$sesion', '$cedulaSesion')";
    $query=mysqli_query($mysqli, $sql);
    if($query)
    {
        echo "se inserto";
    }
    else 
    {
        echo"No inserto";
    }
}



?>