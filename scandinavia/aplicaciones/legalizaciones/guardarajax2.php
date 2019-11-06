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




$tipol = $_POST['tipolegalizacion'];
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
if (!isset($_POST['ValorAnticipo'])) { 
     $anticipo = 0;
}
else{
	$anticipo =$_POST['ValorAnticipo'];
}

$anticipo = str_replace(",","",$anticipo);

//se crea la cabeza de la legalizacion
if($crea == "ok"){
		
		
		$query_Cabeza = "INSERT INTO lg_cabeza (tipolegalizacion,valoranticipo,fecha,identificacion,nombre,cargo,ctocto,linea,area,userid, observaciones,estado) VALUES ('$tipol','$anticipo', '$fechaanticipo', '$identificacion', '$nombre', '$cargo', '$ctocto', '$linea', '$area', $useridll ,  '$txtobservaciones', '0')";
			 mysqli_query($mysqli, $query_Cabeza);		
			 //echo "<BR>". $query_Cabeza; 
			$consecutivo = mysqli_insert_id($mysqli);
			
}
//detale de legalizacion

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
			
						
			$sql = "INSERT INTO lg_det_cabeza (id,fecfact,factura , nit , establecimiento , ciudad, cinversion,tipogasto, concepto, descripcion, moneda,valor, total, fichero, tipo,anticipoE1, anticipoP1, recibido, tipoCodigo)
				 VALUES( $consecutivo, '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '$cinversion[$i]','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]', '$valor[$i]',$txttot[$i], '$nombre', '$tipo', '$anticipoE1', '$anticipoP1', 1, '$tipoCodigo')";
				  //echo "<BR>". $sql;
				  
				  mysqli_query($mysqli, $sql);
				   				
				  
			//Grabamos los datos en la tabla personal
			
			
				//se verifica ciudad
				$sqlc = "select * from ciudades where nombre = '$ciudad[$i]'";
				$result  = mysqli_query($mysqli, $sqlc);
				$rowcount = mysqli_num_rows($result);
				if ($rowcount<1){
					$sql = "INSERT INTO ciudades(nombre) values ('$ciudad[$i]')";
					mysqli_query($mysqli, $sqlc);
				}
				
				//se verifica proveedor
				$sqlp = "select * from proveedores where nit = '$nit[$i]'";
				$result  = mysqli_query($mysqli, $sqlp);
				$rowcount = mysqli_num_rows($result);
				if ($rowcount<1){
					$sql = "INSERT INTO proveedores (nit, razonsocial, tipo) values ('$nit[$i]', '$establecimiento[$i]', 1)";
					mysqli_query($mysqli, $sqlp);
				}
			}


$sql = "Delete from lg_det_cabeza where id = $consecutivo and fecfact = '' and factura = '' and nit = '' and establecimiento = ''";
mysqli_query($mysqli, $sql);
$sql = "Delete from ciudades where nombre = ''";
mysqli_query($mysqli, $sql);		


$_SESSION['uId'] = $consecutivo;

//echo "Thank you, " . $_POST['factura'] . ". Your information has been inserted.";

echo $consecutivo;


//header('Location: /scandinavia/aplicaciones/legalizaciones/index.php?OP=Legalizaciones');	

?>



















