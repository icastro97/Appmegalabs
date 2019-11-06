<?php
require ('phpmailer/class.phpmailer.php');
require_once '../../mcv5/clases/DB.class.php';
  require '../../seguridad/config.php';

  $user = $_SESSION['user_id'];
 
$consecutivo = $_POST['documento'];
$id = $_POST['id'];


$sql = "UPDATE transferencia_val set estado = '1', ultimoCambioEstado = NOW() WHERE id_transferencia = '$consecutivo'";

$ejecutar = mysqli_query($mysqli, $sql);

$mysqlis ="INSERT INTO `Historico_facturas`(`id_factura`, `usuario`, `nuevo_estado`, `fecha_cambio`, `Observacion`) VALUES ('$consecutivo','$user',1,NOW(),'Se hace distribucion de Factura')";
$query = mysqli_query($mysqli, $mysqlis);

if ($ejecutar) 
{
    $sqls = "SELECT email FROM system_users where u_userid = ".$id; 
    $eje = mysqli_query($mysqli, $sqls);
    while($row = mysqli_fetch_array($eje))
    {
        $correo =  $row['email'];
    }
    
    $mys = "SELECT * FROM transferencia_val where id_transferencia = ".$consecutivo;	
    $mysql = mysqli_query($mysqli, $mys);	
    while($row = mysqli_fetch_array($mysql))
    {
        $proveedor = $row['establecimiento'];
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
$asunto = "Factura ".$consecutivo." ha sido asignada";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = " Estimado/a  , <br><br>
El estado de la factura $consecutivo es <strong>SIN VERIFICAR</strong>
<br><br> Proveedor: $proveedor
<br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode($body); // Mensaje a enviar
$mail->Send(); // Envía el correo.
    
    $response = "OK";
    echo $response;
}
else{
    $response = mysqli_error($sql);
           
    echo $response;
}


?>