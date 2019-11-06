<?php
session_start();
require_once '../../mcv5/clases/DB.class.php';
require ('phpmailer/class.phpmailer.php');
$db = new DB();

$tipo =$_REQUEST['tipo'];
$recibo =$_REQUEST['rcid'];
$estadoscartera =$_REQUEST['estadoscartera'];


if (!isset($_REQUEST['TipRec'])) { 
	$TipRec ="";
}
else{
	$TipRec =$_REQUEST['TipRec'];
}


if (!isset($_REQUEST['ObservacionP'])) {
   $observaciones = "Sin Observacion";
}
else{
	$observaciones =$_REQUEST['ObservacionP'];
}

//$newDate = date("d/m/Y", strtotime($fecha));

$usuariomodifica = $_SESSION["user_id"];





$sql="UPDATE anticipo SET estado = '$estadoscartera',  observacioncontabilidad = '$observaciones', fechacontabilidad = NOW()Where consecutivo = $recibo"; 
$var = mysqli_query($mysqli, $sql);

if($tipo == "Proveedor")
{
    
$sqlazo = "SELECT * FROM anticipo where consecutivo = ".$recibo;
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

    
    
    
        if($estadoscartera == "APRC")
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
                    $mail->AddAddress("mfajardo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    $mail->AddAddress("jacosta1@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    $mail->AddAddress("lbello@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    //$mail->AddAddress("jconde@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    
                    $mail->IsHTML(true); // El correo se envía como HTML
                    $asunto = "Anticipo ".$recibo." ha sido aprobado por contabilidad";
                    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
                    $body = " Estimado/a  $nombre, <br><br>
                    El estado del anticipo $recibo es <strong>$estadoscartera</strong>
                    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
                    <br><br><br>Cordial saludo,
                    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
                    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
                    $mail->Body =utf8_decode($body); // Mensaje a enviar
                    $mail->Send();// Envía el correo.
                    
                    
                    
         
        }
        else if($estadoscartera == "RECC")
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
                    $mail->AddAddress("mfajardo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    $mail->AddAddress("lbello@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    
                    
                    $mail->IsHTML(true); // El correo se envía como HTML
                    $asunto = "Anticipo ".$recibo." ha sido rechazado por contabilidad";
                    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
                    $body = " Estimado/a  $nombre, <br><br>
                    El estado del anticipo $recibo es <strong>$estadoscartera</strong>
                    <br><br>Motivo por: $observaciones
                    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>Appmegalabs.com</a>
                    <br><br><br>Cordial saludo,
                    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
                    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
                    $mail->Body =utf8_decode($body); // Mensaje a enviar
                    $mail->Send(); // Envía el correo.
        }
}
else if($tipo == "Empleado")
{
    
    
$sqlazo = "SELECT * FROM anticipo where consecutivo = ".$recibo;
$query = mysqli_query($mysqli, $sqlazo);
while($row = mysqli_fetch_array($query))
{
    $usuario = $row['identificacion'];
}


$consulta = "SELECT email, full_name FROM system_users WHERE cedula = ". $usuario;
$result = mysqli_query($mysqli, $consulta);
while($row = mysqli_fetch_array($result))
{
   $correo = $row['email'];
   $nombre = $row['full_name'];
}

    
    
    
    if($estadoscartera == "APRC")
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
                    $mail->AddAddress("mfajardo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    $mail->AddAddress("lbello@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    
                    
                    $mail->IsHTML(true); // El correo se envía como HTML
                    $asunto = "Anticipo ".$recibo." ha sido aprobado por contabilidad";
                    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
                    $body = " Estimado/a  $nombre, <br><br>
                    El estado del anticipo $recibo es <strong>$estadoscartera</strong>
                    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
                    <br><br><br>Cordial saludo,
                    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
                    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
                    $mail->Body =utf8_decode($body); // Mensaje a enviar
                    $mail->Send(); // Envía el correo.
                    
                    
                    
         
        }
        else if($estadoscartera == "RECC")
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
                    $mail->AddAddress("mfajardo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    $mail->AddAddress("lbello@scandinavia.com.co"); // Esta es la dirección a donde enviamos
                    
                    
                    $mail->IsHTML(true); // El correo se envía como HTML
                    $asunto = "Anticipo ".$recibo." ha sido rechazado por contabilidad";
                    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
                    $body = " Estimado/a  $nombre, <br><br>
                    El estado del anticipo $recibo es <strong>$estadoscartera</strong>
                    <br><br>Motivo por: $observaciones
                    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>Appmegalabs.com</a>
                    <br><br><br>Cordial saludo,
                    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
                    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
                    $mail->Body =utf8_decode($body); // Mensaje a enviar
                    $mail->Send(); // Envía el correo.
        }
    
    
    
    
    
}




if($_REQUEST['estadoscartera'] == 'RECC'){
$sql="UPDATE anticipo SET habilitado = 0 Where id = $recibo"; 
mysqli_query($mysqli, $sql);
}



header('Location: /scandinavia/aplicaciones/Anticipos/Listados/Contabilidad/index.php?op=Contabilidad');	
?>