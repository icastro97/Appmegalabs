<?php
require_once '../../mcv5/clases/DB.class.php';
require ('phpmailer/class.phpmailer.php');

//En este archivo el query me actualiza el campo de estado que esta en 0 a 1 para que asi aparezca sin verificar en la capa de listados



if(!is_dir("uploads/"))
mkdir("uploads/", 0777);

$file = $_FILES["file"];
$nombre = "img_". $file["name"];
$tipo = $file["type"];
$ruta_provisional = $file["tmp_name"];
$size = $file["size"];
$dimensiones = 0;//getimagesize($ruta_provisional);
$width = 0;//$dimensiones[0];
$height = 0;//$dimensiones[1];
$carpeta = "uploads/";
$src = $carpeta . $nombre;
move_uploaded_file($ruta_provisional, $src); 

$filtro = $_POST['consecutivo'];
$query_Cabeza  	= "update anticipo set estado = 1, archivo = '$nombre', tipoArchivo = '$tipo'  where consecutivo =  " . $filtro;
mysqli_query($mysqli, $query_Cabeza);	


$consulta = "SELECT identificacion, userid FROM anticipo WHERE consecutivo = ".$filtro ;
$query = mysqli_query($mysqli, $consulta);
while($row = mysqli_fetch_array($query))
{
    $nit = $row['identificacion'];
    $usuario = $row['userid'];
}



$consulta = "SELECT email, full_name FROM system_users WHERE u_userid = ". $usuario;
$result = mysqli_query($mysqli, $consulta);
while($row = mysqli_fetch_array($result))
{
   
   $nombre = $row['full_name'];
}




if($nit == "830000167-2" || $nit == "901154297")
{
    header('Location: /scandinavia/aplicaciones/Anticipos/Listados/index.php?op=Listado');				 
}
else
{
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
    $mail->AddAddress("etarapues@scandinavia.com.co"); // Esta es la dirección a donde enviamos
    
    
    $mail->IsHTML(true); // El correo se envía como HTML
    $asunto = "Anticipo ".$filtro." pendiente por revisar";
    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
    $body = "Estimado/a EDGAR FERNANDO TARAPUES CHARRY, <br><br>
    
    El anticipo número $filtro del usuario $nombre esta disponible para su verificación.
    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>Appmegalabs.com</a>
    
    
    <br><br><br>Cordial saludo,
    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
    $mail->Body =utf8_decode( $body); // Mensaje a enviar
    $mail->Send();// Envía el correo.
    header('Location: /scandinavia/aplicaciones/Anticipos/Listados/index.php?op=Listado');				                   
}




			 	
?>