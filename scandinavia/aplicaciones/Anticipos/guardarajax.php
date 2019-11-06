<?php 

require_once("../../seguridad/config.php");
$status = FALSE;

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php'; 


if (isset($_SESSION['uId'])) {
	//existe
	$crea = "no";
	$consecutivo = $_SESSION['uId'];
	} // Checks if session exists 
else {
	//no existe
	$crea = "ok";
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
		
		
		$consulta = "SELECT consecutivo FROM anticipo ORDER BY consecutivo DESC LIMIT 1";  
        $var = mysqli_query($mysqli, $consulta); 
        $resultado = mysqli_num_rows($var);
        
        if($resultado > 0)
        {
            while($row = mysqli_fetch_array($var))
            {
                $consecutivo = $row['consecutivo'] + 1;
            }
            
        }
        else 
            $consecutivo = 1; 
        
        
        
            				   
}		
		for ($i = 0; $i < count($fechaActual); $i++) 
		{	
		   
    	    $valor[$i] = str_replace(",","",$valor[$i]);	
    						
    		$query_Cabeza = "INSERT INTO anticipo (`consecutivo`, `fechaActual`, `identificacion`, `nombre`, `cuenta`, `Tipo`, `banco`, `ciudad`, `cinversion`, `fechaIni`, `fechaFin`, `Moneda`, `valor`, `descripcion`,`userid`, `estado`) VALUES ($consecutivo,'$fechaActual','$identificacion', '$nombre','$cuenta[$i]', '$Tipo[$i]', '$banco[$i]', '$ciudad[$i]', '$cinversion[$i]','$fechaIni','$fechaFin', '$Moneda[$i]','$valor[$i]','$descripcion[$i]', '$userid', '0' )";
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


