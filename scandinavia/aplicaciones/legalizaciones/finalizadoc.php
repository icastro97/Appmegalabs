<?php
require_once '../../mcv5/clases/DB.class.php';
require ('phpmailer/class.phpmailer.php');
$filtro = $_REQUEST['documento'];
$usuario = $_REQUEST['us'];
$apro = $_REQUEST['aprobador'];

$query_Cabeza = "update lg_cabeza set estado = 1, fechaFinalizada = NOW() where id_cabeza =  " . $filtro;
mysqli_query($mysqli, $query_Cabeza);	



$sql = "SELECT email, full_name FROM system_users WHERE u_userid =".$apro;
$query = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_array($query))
{
    $correo = $row['email'];
    $nombre = $row['full_name'];
}

$sql1 = "SELECT full_name FROM system_users WHERE cedula =".$usuario;
$query1 = mysqli_query($mysqli,$sql1);

while($row1 = mysqli_fetch_array($query1))
{
    $user = $row1['full_name'];
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
            $asunto = "Legalizacion ".$filtro." pendiente por aprobar";
            $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
            $body = "Estimado/a $nombre, <br><br>
            
            La legalización número $filtro del usuario $user esta disponible para su verificación.
            <br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>Appmegalabs.com</a>
            
            
            <br><br><br>Cordial saludo,
            <br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
            <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
            $mail->Body =utf8_decode( $body); // Mensaje a enviar
            $mail->Send(); // Envía el correo.
  

header('Location: /scandinavia/aplicaciones/legalizaciones/listadoLegalizacionesAprobador/index.php?op=Listado');				 
 

	 	
?>
