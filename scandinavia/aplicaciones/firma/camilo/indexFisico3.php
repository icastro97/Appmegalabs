<?php
require('../conexion.php');
$fechaActual = $_POST['fechaActual'];
$nombrem = $_POST['nombrem'];
$codigo = $_POST['cod'];
$tipo = $_POST['opcion'];
$cedula = $_POST['cedula'];
$nombreP = $_POST['nombreP'];
$nombreS = $_POST['nombreS'];
$apellidoP = $_POST['apellidoP'];
$apellidoS = $_POST['apellidoS'];
$correo = $_POST['correo'];
$tel = $_POST['telefono'];
$ciudad = $_POST['ciudad'];
$datos3 = $_POST['datotres'];
$userid = $_POST['userid'];
$tipoDocumento = $_POST['tipoDocumento'];

if(!is_dir("documentosFisicos/"))
mkdir("documentosFisicos/", 0777);
    
    
    

    

    $archivo = $_FILES['archivo1'];
	$nombre = time() .  $archivo['name'];
	$tipos =  $archivo["type"];
	$ruta_provisional =   $archivo["tmp_name"];
	$size =   $archivo["size"];
	$dimensiones = 0;//getimagesize($ruta_provisional);
	$width = 0;//$dimensiones[0];
	$height = 0;//$dimensiones[1];
	$carpeta = "../documentosFisicos/";
	$src = $carpeta . $nombre;
	
	move_uploaded_file($ruta_provisional, $src); 


            global $bd;
            
            
            $actualizarTablaUno = "UPDATE formulario_firma SET codigo = '$codigo' , nombremedico = '$nombrem', `tipo` = '$tipo', `cedula` = '$cedula', `nombrep` = '$nombreP',`nombres` = '$nombreS',`apellidop` = '$apellidoP' ,`apellidos` = '$apellidoS', `correo`  = '$correo', `fechaActual` = '$fechaActual', `telefono` = '$tel', ciudad = '$ciudad', `transferenciaValor` = '$datos3', userid = '$userid', adjuntoDos = '$nombre'  WHERE codigo = ".$codigo;
            $ejecucion = mysqli_query($bd, $actualizarTablaUno);
            
            $sql = "INSERT INTO `formulario_firma2`(tipo2, codigo, nombremedico, `tipo`, `cedula`, `nombrep`,`nombres`,`apellidop`,`apellidos`, `correo`, `fechaActual`, `telefono`, ciudad, `transferenciaValor`, documentoTransferencia, userid, fechaActualizacion) VALUES ('$tipoDocumento', '$codigo','$nombrem','$tipo','$cedula', '$nombreP','$nombreS', '$apellidoP', '$apellidoS', '$correo', '$fechaActual', '$tel', '$ciudad', '$datos3', '$nombre', '$userid', NOW())";
            $ejecutar = mysqli_query($bd,$sql);
            $ultimo = mysqli_insert_id($bd);            
            
            
            $query = "SELECT * FROM formulario_firma2 where id_consentimiento = ".$ultimo;
            $ejecution = mysqli_query($bd, $query);
            $numero = mysqli_num_rows($ejecution);
            
            if($numero >0)
            {
              header('Location: alertaB.php');
            }
            else
            {
              header('Location: alertaM.php');  
            }




?>