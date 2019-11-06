<?php
require_once '../../mcv5/clases/DB.class.php';

//En este archivo el query me actualiza el campo de estado que esta en 0 a 1 para que asi aparezca sin verificar en la capa de listados



if(!is_dir("uploads/"))
mkdir("uploads/", 0777);

$file = $_FILES["file"];
$nombre = time() . $file["name"];
$tipo = $file["type"];
$ruta_provisional = $file["tmp_name"];
$size = $file["size"];
$dimensiones = 0;//getimagesize($ruta_provisional);
$width = 0;//$dimensiones[0];
$height = 0;//$dimensiones[1];
$carpeta = "uploads/";
$src = $carpeta . $nombre;
move_uploaded_file($ruta_provisional, $src); 

$filtro = $_POST['documento'];

$query_Cabeza  	= "update anticipo set estado = 1, archivo = '$nombre', tipoArchivo = '$tipo'  where consecutivo =  " . $filtro;
mysqli_query($mysqli, $query_Cabeza);	


header('Location: /scandinavia/aplicaciones/Anticipos/listadoAnticipos.php?op=LISTADO ANTICIPOS');	

			 	
?>