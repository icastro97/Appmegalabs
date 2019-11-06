<?php
require ('phpmailer/class.phpmailer.php');
require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];
$user = $_POST['user'];
$obser = $_POST['obser'];

$sql = "UPDATE transferencia_val set tipoAPR = 'NO ACEPTO', observacionAc = '$id', ultimoCambioEstado = NOW() WHERE id_transferencia = '$obser'";
$ejecutar = mysqli_query($mysqli, $sql);
$consulta = "INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`,`Observacion`) VALUES ('$obser','$user','NO ACEPTO',NOW(),'$id')";
    $ejecutar = mysqli_query($mysqli, $consulta);

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
$asunto = "Factura ".$obser." ha sido rechazada";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = " Estimado/a  , <br><br>
El estado de la factura $obser es <strong>RECHAZADA</strong>
<br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode($body); // Mensaje a enviar
$mail->Send(); // Envía el correo.
    




if ($ejecutar == TRUE) {
    $consulta = "INSERT INTO Historico_facturas (id_factura, usuario, nuevo_estado, fecha_cambio) VALUES ('$obser', '$user', 'NO ACEPTO', NOW())";
    $query = mysqli_query($mysqli, $consulta);
    if ($query == TRUE) {
        $response = "bien";
        echo $response;
    }
    else {
        $response = mysqli_error($consulta);
        echo $response;
    }

}
else{
    $response = mysqli_error($sql);
    echo $response;
}


?>