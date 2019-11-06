<?php

require('conexion.php');
require('consultas.php');

$nombrem = $_POST['nombrem'];
$codigo = $_POST['cod'];
$opcion = $_POST['opcion'];
$cedula = $_POST['cedula'];
$nombreP = $_POST['nombreP'];
$nombreS = $_POST['nombreS'];
$apellidoP = $_POST['apellidoP'];
$apellidoS = $_POST['apellidoS'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$ciudad = $_POST['ciudad'];
$fechaActual = $_POST['fechaActual'];
$userid = $_POST['userid'];
$dato = $_POST['dato'];
$datouno = $_POST['datouno'];
$datodos = $_POST['datodos'];
$datotres = $_POST['datotres'];


if(!is_dir("documentosFisicos/"))
mkdir("documentosFisicos/", 0777);
    
    
    

    

    $archivo = $_FILES['archivo'];
	$nombre = time() .  $archivo['name'];
	$tipo =  $archivo["type"];
	$ruta_provisional =   $archivo["tmp_name"];
	$size =   $archivo["size"];
	$dimensiones = 0;//getimagesize($ruta_provisional);
	$width = 0;//$dimensiones[0];
	$height = 0;//$dimensiones[1];
	$carpeta = "documentosFisicos/";
	$src = $carpeta . $nombre;
	
	move_uploaded_file($ruta_provisional, $src); 


              global $bd;
           
            $sql = "INSERT INTO `formulario_firma`( `codigo`, `nombremedico`, `tipo`, `cedula`, `nombrep`, `nombres`, `apellidop`, `apellidos`, `correo`, `fechaActual`, `userid`, `telefono`, `ciudad`, `tratamientoDatos`, `publicidad`, `materialCientifico`, `transferenciaValor`, `adjunto`) VALUES ('$codigo', '$nombrem','$opcion','$cedula', '$nombreP','$nombreS', '$apellidoP', '$apellidoS', '$correo', '$fechaActual', '$userid', '$telefono', '$ciudad','$dato','$datouno','$datodos', '$datotres','$nombre')";
            $ejecutar = mysqli_query($bd,$sql);
            
            $consecutivo = mysqli_insert_id($bd);
           
            
            $query = "SELECT * FROM formulario_firma where id_consentimiento = ".$consecutivo;
            $ejecution = mysqli_query($bd, $query);
            $numero = mysqli_num_rows($ejecution);
            
            if($numero > 0)
            {
              header('Location: alerta1.php');
            }
            else
            {
              header('Location: alerta2.php');  
            }


    if(!empty($datotres))
    {
    
        $archivo1 = $_FILES['archivo1'];
    	$nombre1 = time() .  $archivo1['name'];
    	$tipo1 =  $archivo1["type"];
    	$ruta_provisional1 =   $archivo1["tmp_name"];
    	$size1 =   $archivo1["size"];
    	$dimensiones1 = 0;//getimagesize($ruta_provisional);
    	$width1 = 0;//$dimensiones[0];
    	$height1 = 0;//$dimensiones[1];
    	$carpeta1 = "documentosFisicos/";
    	$src1 = $carpeta1 . $nombre1;
    	
    	move_uploaded_file($ruta_provisional1, $src1); 
    	
    	
    	
    	
    	    global $bd;
           
            $sql = "UPDATE formulario_firma SET adjuntoDos = '$nombre1' where id_consentimiento = ". $consecutivo;
            $ejecutar = mysqli_query($bd,$sql);
           
    }
   
             
    	
	
	
 	
	

?>