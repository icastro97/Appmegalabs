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



$tipol = $_POST['TipoLegalizacion'];
$fechaanticipo = $_POST['fecha'];
$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$cargo = $_POST['cargo'];
$ctocto = $_POST['ctocto'];
$linea = $_POST['Linea'];
$area = $_POST['Area'];
$fechareal =  date("d-m-Y");
$useridll = $_POST['useridl'];
$txtobservaciones = $_POST['txtobservaciones'];
$check = $_POST['cambioaprobador'];






	if(empty($check))
	{	
		if($crea == "ok"){
			$aprobadorPrincipal = $_POST['nombreaprobador'];

			
			$query_Cabeza = "INSERT INTO lg_cabeza (`tipolegalizacion`,  `fecha`, `identificacion`, `nombre`, `cargo`, `ctocto`, `linea`, `area`, `userid`, observaciones, estado, `aprobador`, boton) VALUES ('$tipol', '$fechaanticipo', '$identificacion', '$nombre', '$cargo', '$ctocto', '$linea', '$area', $useridll , '$txtobservaciones', '0', '$aprobadorPrincipal', '1')";
			
			mysqli_query($mysqli, $query_Cabeza);		
				
				//echo "<BR>". $query_Cabeza; 
				$consecutivo = mysqli_insert_id($mysqli);
				
			}



				$fecfact=$_POST['fechasiguiente'];
				$factura=$_POST['factura'];
				$nit=$_POST['nit'];
				$establecimiento=$_POST['establecimiento'];
				$ciudad=$_POST['ciudad'];
				$cinversion=$_POST['cinversion'];
				$tgasto = $_POST['TipoGasto'];
				$concepto=$_POST['concepto'];
				$descripcion=$_POST['descripcion'];
				$valor = $_POST['valor'];
				$txttot = "0";
				$moneda = $_POST['Moneda'];
				$anticipoP1 = $_POST['anticipoP1'];
				$anticipoE1 = $_POST['anticipoE1'];
				$tipoCodigo = $_POST['tipoCodigo'];
				
				if(!is_dir("uploads/"))
					mkdir("uploads/", 0777);
					
					
		
				
				
				
					for ($i = 0; $i < count($fecfact); $i++) {	
					
					//if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
					$file = $_FILES["file"];
					$nombre = time() . $file["name"][$i];
					$tipo = $file["type"][$i];
					$ruta_provisional = $file["tmp_name"][$i];
					$size = $file["size"][$i];
					$dimensiones = 0;//getimagesize($ruta_provisional);
					$width = 0;//$dimensiones[0];
					$height = 0;//$dimensiones[1];
					$carpeta = "uploads/";
					$src = $carpeta . $nombre;
					move_uploaded_file($ruta_provisional, $src);
					
					
					
					$valor[$i] = str_replace(",","",$valor[$i]);
			
					$sql = "INSERT INTO `lg_det_cabeza`( `id`, `fecfact`, `factura`, `nit`, `establecimiento`, `ciudad`, `cinversion`, `tipogasto`, `concepto`, `descripcion`, `moneda`, `valor`, `total`, `fichero`, `tipo`, `anticipoE1`, `anticipoP1`, `recibido`, tipoCodigo ) VALUES ($consecutivo, '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '".mb_strtoupper($cinversion[$i])."','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]', '$valor[$i]',$txttot[$i], '$nombre', '$tipo', '$anticipoE1', '$anticipoP1', 1, '$tipoCodigo')";
					
					$s = mysqli_query($mysqli, $sql);
					//var_dump(mysqli_error($mysqli));
					$_SESSION['uId'] = $consecutivo;


					echo $consecutivo;
				
		}
	}
	else
	{

		
		$aprobadorSecundario = $_POST['codigoAprobador'];
		if($crea == "ok"){
			
			
			$query_Cabeza = "INSERT INTO lg_cabeza (`tipolegalizacion`,  `fecha`, `identificacion`, `nombre`, `cargo`, `ctocto`, `linea`, `area`, `userid`, observaciones, estado, `aprobador`, boton) VALUES ('$tipol', '$fechaanticipo', '$identificacion', '$nombre', '$cargo', '$ctocto', '$linea', '$area', $useridll , '$txtobservaciones', '0', '$aprobadorSecundario', '1')";
				mysqli_query($mysqli, $query_Cabeza);		
				//echo "<BR>". $query_Cabeza; 
				$consecutivo = mysqli_insert_id($mysqli);
			}	
				$fecfact=$_POST['fechasiguiente'];
				$factura=$_POST['factura'];
				$nit=$_POST['nit'];
				$establecimiento=$_POST['establecimiento'];
				$ciudad=$_POST['ciudad'];
				$cinversion=$_POST['cinversion'];
				$tgasto = $_POST['TipoGasto'];
				$concepto=$_POST['concepto'];
				$descripcion=$_POST['descripcion'];
				$valor = $_POST['valor'];
				$txttot = "0";
				$moneda = $_POST['Moneda'];
				$anticipoP1 = $_POST['anticipoP1'];
				$anticipoE1 = $_POST['anticipoE1'];
				$tipoCodigo = $_POST['tipoCodigo'];
				
				if(!is_dir("uploads/"))
					mkdir("uploads/", 0777);
					
					
		
				
				
				
					for ($i = 0; $i < count($fecfact); $i++) {	
					
					//if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
					$file = $_FILES["file"];
					$nombre = time() . $file["name"][$i];
					$tipo = $file["type"][$i];
					$ruta_provisional = $file["tmp_name"][$i];
					$size = $file["size"][$i];
					$dimensiones = 0;//getimagesize($ruta_provisional);
					$width = 0;//$dimensiones[0];
					$height = 0;//$dimensiones[1];
					$carpeta = "uploads/";
					$src = $carpeta . $nombre;
					move_uploaded_file($ruta_provisional, $src);
					
					
					$valor[$i] = str_replace(",","",$valor[$i]);
			
					$sql = "INSERT INTO `lg_det_cabeza`( `id`, `fecfact`, `factura`, `nit`, `establecimiento`, `ciudad`, `cinversion`, `tipogasto`, `concepto`, `descripcion`, `moneda`, `valor`, `total`, `fichero`, `tipo`, `anticipoE1`, `anticipoP1`, `recibido`, tipoCodigo ) VALUES ($consecutivo, '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '".mb_strtoupper($cinversion[$i])."','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]', '$valor[$i]',$txttot[$i], '$nombre', '$tipo', '$anticipoE1', '$anticipoP1', 1, '$tipoCodigo')";
					$s = mysqli_query($mysqli, $sql);
					//var_dump(mysqli_error($mysqli));

					$_SESSION['uId'] = $consecutivo;


					echo $consecutivo;
				
					
		}
	}


?>


