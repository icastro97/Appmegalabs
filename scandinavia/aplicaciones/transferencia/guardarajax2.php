<?php 
require ('phpmailer/class.phpmailer.php');
require_once("../../seguridad/config.php");
$status = FALSE;

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';





$tipol = $_POST['tipolegalizacion'];

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
$aprobadorPrincipal = $_POST['codigoAprobador'];	
$valorSinImpuestos = $_POST['valorSinImpuestos'];
$valorImpuesto = $_POST['valorImpuesto'];	
$valorIca = $_POST['valorIca'];	
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
$tipoCodigo = $_POST['tipoCodigo'];
$iduser = $_POST['idu'];
$fechamos = $_POST['fechamos'];
$opciones = $_POST['opciones'];
$radicado = $_POST['radicado'];

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
            
            $descrip = str_replace("'","",$descripcion);

						
			if($radicado == 'NO'){
			    
			    $sql = "INSERT INTO transferencia_val (tipoFactura, radicado, fecfact, factura, nit , establecimiento , ciudad, cinversion,tipogasto, concepto, descripcion, moneda,`valorSinImpuesto`, valorImpuesto, valorIca , fichero, tipo,tipoCodigo, fecha_registro, estado, user_id, aprContabilidad )
				 VALUES('$opciones',NULL, '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '".mb_strtoupper($cinversion[$i])."','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]','$valorSinImpuestos[$i]', '$valorImpuesto[$i]', '$valorIca[$i]','$nombre', '$tipo', '$tipoCodigo', NOW(), '2' , '$iduser', '193')";
				  $s = mysqli_query($mysqli, $sql);
				 
				  $consecutivo = mysqli_insert_id($mysqli);	
			    }
			 else{
			    
			     $sql = "INSERT INTO transferencia_val (tipoFactura, radicado, fecfact, factura, nit , establecimiento , ciudad, cinversion,tipogasto, concepto, descripcion, moneda,`valorSinImpuesto`, valorImpuesto, valorIca , fichero, tipo,tipoCodigo, fecha_registro, estado, user_id, aprContabilidad )
				 VALUES('$opciones','$radicado', '$fecfact[$i]' , '$factura[$i]' ,'$nit[$i]' , '$establecimiento[$i]' , '$ciudad[$i]', '".mb_strtoupper($cinversion[$i])."','$tgasto[$i]','$concepto[$i]','$descripcion[$i]','$moneda[$i]','$valorSinImpuestos[$i]', '$valorImpuesto[$i]', '$valorIca[$i]','$nombre', '$tipo', '$tipoCodigo', NOW(), '2' , '$iduser', '193')";
				 
				  $s = mysqli_query($mysqli, $sql);
				  
				  $consecutivo = mysqli_insert_id($mysqli);	
			 }


				  
			
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
			
			$querys = "UPDATE `transferencia_val` SET valorSinImpuesto = REPLACE(valorSinImpuesto, ' ', '')";
            $ejecucion = mysqli_query($mysqli,$querys);
				  
			$mail = new PHPMailer();

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "mail.appmegalabs.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
$mail->Username = "aplicativos@appmegalabs.com"; // Correo completo a utilizar
$mail->Password = "rLgpJ4h&eyO~"; // Contraseña
$mail->Port = 587; // Puerto a utilizar

//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
$mail->From = "aplicativos@appmegalabs.com"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "Administrador";

//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
$mail->AddAddress("acgonzalez@scandinavia.com.co"); // Esta es la dirección a donde enviamos


$mail->IsHTML(true); // El correo se envía como HTML
$asunto = "Factura ".$consecutivo." ha sido creada";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = " Estimado/a  , <br><br>
El estado de la factura $consecutivo es <strong>SIN DISTRUIR</strong>
<br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode($body); // Mensaje a enviar
$mail->Send(); // Envía el correo.
    


			echo $consecutivo;

	

?>



















