<?php

require('conexion.php');
require ('phpmailer/class.phpmailer.php');

$nit = $_POST['nit1'];
$correo = $_POST['correo1'];
$codigo = $_POST['codigoAxapta'];


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
$asunto = "Codigo";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = "Estimado/a, <br><br>

Scandinavia Pharma Ltda mediante este correo envía el código el cual debe ingresar en la plataforma <a href='https://appmegalabs.com/scandinavia/aplicaciones/video/certificados/index.php'>Appmegalabs.com</a> para la descarga de los certificados de retenciones dicho código puede utilizarlo para las próximas descargas. Tener presente que este código es responsabilidad de la compañía y debe ser intransferible.
<br>
Este es el código asignado a su nit.
<br>
<strong>$codigo</strong>

<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='http://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode( $body); // Mensaje a enviar

if($mail->Send())
{
    $respuesta = ok;
    echo $respuesta;
}
else
{
    $respuesta =  no;
    echo $respuesta;
}


?> 