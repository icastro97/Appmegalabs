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



	$fechaActual = $_POST['fechaActual'];
	$identificacion = $_POST['identificacion'];
	$nombre = $_POST['nombre'];
	$cuenta = $_POST['cuenta'];
	$Tipo = $_POST['Tipo'];
	$banco = $_POST['banco'];
	$ciudad = $_POST['ciudad'];
	$cinversion = $_POST['cinversion'];
	$fechaIni = $_POST['fechaIni'];
	$fechaFin = $_POST['fechaFin'];
	$Moneda = $_POST['Moneda'];
	$valor = $_POST['valor'];
	$descripcion = $_POST['descripcion'];
	$userid = $_POST['userid'];
	


//se crea la cabeza de la legalizacion
if($crea == "ok"){
		
		
		$consulta = "SELECT AUTO_INCREMENT FROM information_schema.TABLES where TABLE_SCHEMA ='scandapp_app' and TABLE_NAME = 'anticipo'";	  
        $var = mysqli_query($mysqli, $consulta); 
        		
        		
        while ($resultado = mysqli_fetch_assoc($var))
        	    $consecutivo = $resultado['AUTO_INCREMENT']; 
}		
		for ($i = 0; $i < count($fechaActual); $i++) 
		{	
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
    						
    		$query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `fechaActual`, `identificacion`, `nombre`, `cuenta`, `Tipo`, `banco`, `ciudad`, `cinversion`, `fechaIni`, `fechaFin`, `Moneda`, `valor`, `descripcion`,`userid`, `estado`) VALUES ($consecutivo,'$fechaActual','$identificacion', '$nombre','$cuenta[$i]', '$Tipo[$i]', '$banco[$i]', '$ciudad[$i]', '$cinversion[$i]','$fechaIni','$fechaFin', '$Moneda[$i]','$valor[$i]','$descripcion[$i]', '$userid', '0', $nombre, $tipo )";
    		mysqli_query($mysqli, $query_Cabeza ); 
    			 //var_dump($query_Cabeza);
    			 //echo mysqli_error($mysqli); 
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



?>


