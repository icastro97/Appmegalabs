<?php 

require_once("../../seguridad/config.php");
$status = FALSE;

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';

$tipol = $_REQUEST['TipoLegalizacion'];
$fechaanticipo = $_REQUEST['fecha'];
$identificacion = $_REQUEST['identificacion'];
$nombre = $_REQUEST['namel'];
$cargo = $_REQUEST['cargo'];
$ctocto = $_REQUEST['ctocto'];
$linea = $_REQUEST['Linea'];
$area = $_REQUEST['Area'];
$fechareal =  date("d-m-Y");
$useridll = $_REQUEST['useridl'];
$txtobservaciones = $_REQUEST['txtobservaciones'];

if (!isset($_REQUEST['ValorAnticipo'])) { 
     $anticipo = 0;
}
else{
	$anticipo =$_REQUEST['ValorAnticipo'];
}


//se crea la cabeza de la legalizacion
		
		$query_Cabeza = "INSERT INTO lg_cabeza (tipolegalizacion,valoranticipo,fecha,identificacion,nombre,cargo,ctocto,linea,area,userid,fechareal, observaciones) VALUES ('$tipol','$anticipo', '$fechaanticipo', '$identificacion', '$nombre', '$cargo', '$ctocto', '$linea', '$area', $useridll , '$fechareal' , '$txtobservaciones' )";
			 mysqli_query($mysqli, $query_Cabeza);		
			 echo "<BR>". $query_Cabeza; 
			$consecutivo = mysqli_insert_id($mysqli);
			
			 
//detale de legalizacion

		$fecfact=$_REQUEST['fechasiguiente'];
		$factura=$_REQUEST['factura'];
		$nit=$_REQUEST['nit'];
		$establecimiento=$_REQUEST['establecimiento'];
		$ciudad=$_REQUEST['ciudad'];
		$cinversion=$_REQUEST['cinversion'];
		$tgasto = $_REQUEST['TipoGasto'];
		$concepto=$_REQUEST['concepto'];
		$descripcion=$_REQUEST['descripcion'];
		$valor = $_REQUEST['valor'];
		$txttot = $_REQUEST['txttot'];
		$moneda = $_REQUEST['Moneda'];
		
		
		if(!is_dir("uploads/"))
			mkdir("uploads/", 0777);
			
			

		
		
		
			for ($i = 0; $i < count($fecfact); $i++) {	
			
			//if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
			$file = $_FILES["file"];
			$nombre = time() . $file["name"][$i];
			$tipo = $file["type"][$i];
			$ruta_provisional = $file["tmp_name"][$i];
			$size = $file["size"][$i];
			$dimensiones = getimagesize($ruta_provisional);
			$width = $dimensiones[0];
			$height = $dimensiones[1];
			$carpeta = "uploads/";
			$src = $carpeta . $nombre;
			 move_uploaded_file($ruta_provisional, $src);   

			
			
						
			$sql = "INSERT INTO lg_det_cabeza (id,fecfact,factura , nit , establecimiento , ciudad, cinversion,tipogasto, concepto, descripcion, moneda,valor, total, fichero, tipo)
				 VALUES( $consecutivo, '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '$cinversion[$i]','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]', '$valor[$i]',$txttot[$i], '$nombre', '$tipo')";
				  echo "<BR>". $sql;
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

header('Location: /scandinavia/aplicaciones/legalizaciones/index.php?OP=Legalizaciones');	

?>


