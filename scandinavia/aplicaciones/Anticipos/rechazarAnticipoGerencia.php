<?php

require_once '../../mcv5/clases/DB.class.php';
require ('phpmailer/class.phpmailer.php');

$id_anticipo = $_POST['id'];
$descripcion = $_POST['descripcion'];




$sqlazo = "SELECT * FROM anticipo where consecutivo = ".$id_anticipo;
$query = mysqli_query($mysqli, $sqlazo);
while($row = mysqli_fetch_array($query))
{
    $usuario = $row['userid'];
}


$consulta = "SELECT email, full_name FROM system_users WHERE u_userid = ". $usuario;
$result = mysqli_query($mysqli, $consulta);
while($row = mysqli_fetch_array($result))
{
   $correo = $row['email'];
   $nombre = $row['full_name'];
}

$consulta="UPDATE anticipo SET estado = 'RGER', observacionContabilidad='$descripcion' WHERE consecutivo =".$id_anticipo;
$sql = mysqli_query($mysqli, $consulta);

if(!$sql)
{
die(mysqli_error($mysqli));
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
$mail->AddAddress("$correo"); // Esta es la dirección a donde enviamos



$mail->IsHTML(true); // El correo se envía como HTML
$asunto = "Anticipo ".$id_anticipo." ha sido rechazada por gerencia";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = " Estimado/a  $nombre, <br><br>
El estado del Anticipo $id_anticipo es <strong> RGER </strong>
<br>
El motivo del rechazo: $descripcion
<br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode($body); // Mensaje a enviar
$mail->Send(); // Envía el correo.
echo "Actualizado";

}

 	
 

?> 