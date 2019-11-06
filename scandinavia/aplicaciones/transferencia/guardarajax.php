<?php 


require_once("../../seguridad/config.php");

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';







$fecfact=$_POST['fechasiguiente'];
$factura=$_POST['factura'];
$nit=$_POST['nit'];
$establecimiento=$_POST['establecimiento'];
$ciudad=$_POST['ciudad'];
$cinversion=$_POST['cinversion'];
$tgasto = $_POST['TipoGasto'];
$concepto=$_POST['concepto'];
$descripcion=$_POST['descripcion'];
$valorSinImpuestos = $_POST['valorSinImpuestos'];
$valorImpuesto = $_POST['valorImpuesto'];
$txttot = "0";
$moneda = $_POST['Moneda'];
$tipoCodigo = $_POST['tipoCodigo'];
$aprobadorPrincipal = $_POST['codigoAprobador'];				
$useridll = $_POST['useridl'];

if(!is_dir("uploads/"))
mkdir("uploads/", 0777);






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

		$sql = "INSERT INTO `transferencia_val`(`fecfact`, `factura`, `nit`, `establecimiento`, `ciudad`, `tipogasto`, `concepto`, `descripcion`, `moneda`, `valorSinImpuesto`, valorImpuesto , `fichero`, `tipo`, `tipoCodigo`, `fecha_registro`, aprobador) VALUES ('$fecfact', '$factura', '$nit', '$establecimiento', '$ciudad', '$TipoGasto', '$concepto', '$descripcion', '$moneda', '$valorSinImpuestos', '$valorImpuesto' , '$nombre', '$tipo', NOW(), '$aprobadorPrincipal')";
		
		$s = mysqli_query($mysqli, $sql);

		$_SESSION['uId'] = $consecutivo;


		echo $consecutivo;



?>


