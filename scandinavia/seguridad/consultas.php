<?php
require_once '../mcv5/clases/DB.class.php'; 

    function insertarDatos($titulo, $fechaActual, $fechaSiguiente, $descripcion, $comentario, $nombre)
    {
        global $mysqli;
        $Sql = "INSERT INTO formulario_denuncia(`titulo`, `fechaActual`, `fechaIncidente`, `descripcion`, `comentario`, `archivo`) VALUES('$titulo', '$fechaActual', '$fechaSiguiente', '$descripcion', '$comentario', '$nombre')";
        $query = mysqli_query($mysqli, $Sql);
        
    }   



?>