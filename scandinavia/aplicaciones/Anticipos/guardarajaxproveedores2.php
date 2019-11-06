<?php

require_once("../../seguridad/config.php");
$status = FALSE;

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php'; 


if (isset($_SESSION['uId'])) {
	//existe
	$crea = "no";
	$consecutivo = $_POST['docupdate'];
	} // Checks if session exists 
else {
	//no existe
	$crea = "no";
	$consecutivo = $_POST['docupdate'];
	} 




$tipos = $_POST['tp'];
$fechaActual = $_POST['fechaActual'];
$nit = $_POST['nit'];
$establecimiento = $_POST['establecimiento'];
$moneda = $_POST['Moneda'];
$valor = $_POST['valor'];
$efectivo = $_POST['efectivo'];
$transferencia = $_POST['transferencia'];
$cheque = $_POST['cheque'];
$inversioncom = $_POST['inversioncom'];
$otros = $_POST['otros'];
$evento = $_POST['evento'];
$cinversion = $_POST['cinversion'];
$fechaini = $_POST['fechaini'];
$fechafin = $_POST['fechafin'];
$descripcion = $_POST['descripcion'];
$userid = $_POST['useridl'];
$namel = $_POST['username'];
$fechadesembolso = $_POST['fechadesembolso'];




if($crea == "ok"){
		
		
    $consulta = "SELECT AUTO_INCREMENT FROM information_schema.TABLES where TABLE_SCHEMA ='scandapp_app' and TABLE_NAME = 'anticipo'";	  
    $var = mysqli_query($mysqli, $consulta); 
            
            
    while ($resultado = mysqli_fetch_assoc($var))
            $consecutivo = $resultado['AUTO_INCREMENT']; 
}		

if(empty($check))
 {

    for ($i = 0; $i < count($fechaActual); $i++) 
    {	
        $nombreaprobador = $_POST['nombreaprobador'];

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
        
        $valor[$i] = str_replace(",","",$valor[$i]);	
                        
        $query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `tipo`, `fechaActual`, `identificacion`, `nombre`, `moneda`, `monto`, `efectivo`, `transferencia`, `cheque`, `inversioncom`, `otros`, fechadesembolso,`evento`, `cinversion`, `fechaini`, `fechafin`, `descripcion`, `userid`, `nombreUsuario`, `estado`, `archivo`, `tipoArchivo`, aprobador) VALUES ($consecutivo, '$tipos','$fechaActual','$nit[$i]', '$establecimiento[$i]','$moneda[$i]', '$valor[$i]', '$efectivo', '$transferencia', '$cheque', '$inversioncom', '$otros', '$fechadesembolso','$evento', '$cinversion', '$fechaini','$fechafin','$descripcion', '$userid','$namel', '0', '$nombre', '$tipo', '$nombreaprobador' )";
        mysqli_query($mysqli, $query_Cabeza); 
            //var_dump($query_Cabeza);
            
                //echo "<BR>". $sql; 
                
            //Grabamos los datos en la tabla personal
            
            
                //se verifica ciudad
                $sqlc = "select * from ciudades where nombre = '$ciudad[$i]'";
                $result  = mysqli_query($mysqli, $sqlc);
                $rowcount = mysqli_num_rows($result);
                if ($rowcount<1){
                    $sqlc = "INSERT INTO ciudades(nombre) values ('$ciudad[$i]')";
                    mysqli_query($mysqli, $sqlc);
                } 
    }		
        


    


                           




/*$sql = "Delete from anticipo where consecutivo = $consecutivo and fechaActual = '' and identificacion = '' and nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from ciudades where nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from bancos where descripcion = ''";
mysqli_query($mysqli, $sql);*/ 


$_SESSION['uId'] = $consecutivo;


echo $consecutivo;

 }
 else 
 {
    for ($i = 0; $i < count($fechaActual); $i++) 
    {	
        $aprobador = $_POST['codigoAprobador'];

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
        
        $valor[$i] = str_replace(",","",$valor[$i]);	
                        
        $query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `tipo`, `fechaActual`, `identificacion`, `nombre`, `moneda`, `monto`, `efectivo`, `transferencia`, `cheque`, `inversioncom`, `otros`, `evento`, `cinversion`, `fechaini`, `fechafin`, `descripcion`, `userid`, `nombreUsuario`, `estado`, `archivo`, `tipoArchivo`, aprobador) VALUES ($consecutivo, '$tipos','$fechaActual','$nit[$i]', '$establecimiento[$i]','$moneda[$i]', '$valor[$i]', '$efectivo', '$transferencia', '$cheque', '$inversioncom', '$otros', '$evento', '$cinversion', '$fechaini','$fechafin','$descripcion', '$userid','$namel', '0', '$nombre', '$tipo', '$aprobador' )";
        mysqli_query($mysqli, $query_Cabeza); 
            //var_dump($query_Cabeza);
            
                //echo "<BR>". $sql; 
                
            //Grabamos los datos en la tabla personal
            
            
                //se verifica ciudad
                $sqlc = "select * from ciudades where nombre = '$ciudad[$i]'";
                $result  = mysqli_query($mysqli, $sqlc);
                $rowcount = mysqli_num_rows($result);
                if ($rowcount<1){
                    $sqlc = "INSERT INTO ciudades(nombre) values ('$ciudad[$i]')";
                    mysqli_query($mysqli, $sqlc);
                } 
    }		
        


    


                           




/*$sql = "Delete from anticipo where consecutivo = $consecutivo and fechaActual = '' and identificacion = '' and nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from ciudades where nombre = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from bancos where descripcion = ''";
mysqli_query($mysqli, $sql);*/ 


$_SESSION['uId'] = $consecutivo;


echo $consecutivo;    
 }

?>


