<?php


require_once '../../mcv5/clases/DB.class.php';
require ('phpmailer/class.phpmailer.php');

$cedula = $_POST['cedula'];
$descripcion = $_POST['descripcion'];
$dato = $_POST['dato'];
$datouno = $_POST['datouno'];
$datodos = $_POST['datodos'];
$datotres = $_POST['datotres'];


$sql= "INSERT INTO `bajaDatos`( `cedula`, `observacion`, `tratamientoDatos`, `publicidad`, `materialCientifico`, `transferencia`) VALUES ('$cedula','$descripcion','$dato','$datouno','$datodos','$datotres')";
$query1 = mysqli_query($mysqli, $sql);

$sql = "SELECT id_consentimiento,correo, nombrep, nombres, apellidop, apellidos FROM formulario_firma WHERE cedula =".$cedula;
$query = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_array($query))
{
    $correo = $row['correo'];
    $nombrep = $row['nombrep'];
    $nombres = $row['nombres'];
    $apellidop = $row['apellidop'];
    $apellidos = $row['apellidos'];
}


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
$asunto = "Baja de información";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = "Estimado/a $nombrep $nombres $apellidop $apellidos, <br><br>

Se realizó una solicitud de dar de baja a su información, si esta de acuerdo con esta solicitud omita el correo de lo contrario comuniquese al siguiente correo electronico compliance@scandinavia.com.co


<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='http://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode( $body); // Mensaje a enviar
$mail->Send(); // Envía el correo.


if($query1)
{
    echo "realizado";
}
else
{
    echo "mal";
}


?>