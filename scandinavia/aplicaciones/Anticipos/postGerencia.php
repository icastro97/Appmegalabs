<?php


 require_once '../../mcv5/clases/DB.class.php'; 
 require ('phpmailer/class.phpmailer.php');
$check = $_POST['boton'];
$consecutivo = $_POST['consecutivo'];
$consulta = "UPDATE anticipo  SET confirmacionGerencia='$check' WHERE consecutivo =".$consecutivo;  
$var = mysqli_query($mysqli, $consulta); 

if($var)
{
    
    $sqlazo = "SELECT * FROM anticipo where consecutivo = ".$consecutivo;
    $query = mysqli_query($mysqli, $sqlazo);
    while($row = mysqli_fetch_array($query))
    {
        $aprobador = $row['aprobador'];
    }
    
    
    $consulta = "SELECT email, full_name FROM system_users WHERE u_userid = ". $aprobador;
    $result = mysqli_query($mysqli, $consulta);
    while($row = mysqli_fetch_array($result))
    {
       $correo = $row['email'];
       $nombre = $row['full_name'];
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
    //$mail->AddAddress("mfajardo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
    //$mail->AddAddress("juansebastian.condefarias@gmail.com"); // Esta es la dirección a donde enviamos
    
    $mail->IsHTML(true); // El correo se envía como HTML
    $asunto = "Anticipo ".$consecutivo." para aprobación.";
    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
    $body = " Estimado/a  $nombre, <br><br>
    El anticipo $consecutivo esta disponible para su respectiva aprobación.
    <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>appmegalabs.com</a>
    <br><br><br>Cordial saludo,
    <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
    <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
    $mail->Body =utf8_decode($body); // Mensaje a enviar
    $mail->Send(); // Envía el correo.
    echo "si";
}
else
{
    echo "no";
}

?>