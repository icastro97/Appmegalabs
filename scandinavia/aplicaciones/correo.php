<?php


require ('phpmailer/class.phpmailer.php');


 $mail = new PHPMailer();


    //Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "mail.appscandinavia.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
$mail->Username = "aplicativos@appscandinavia.com"; // Correo completo a utilizar
$mail->Password = "SebastiaN123"; // Contraseña
$mail->Port = 587; // Puerto a utilizar

//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
$mail->From = "aplicativos@appscandinavia.com"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "Aplicaciones Scandinavia Pharma";

$mail->AddAddress("lblanco1@scandinavia.com.co");
$mail->AddAddress("jrosales@scandinavia.com.co");
$mail->AddAddress("agalvis@scandinavia.com.co");
$mail->AddAddress("magudelo@scandinavia.com.co"); 
$mail->AddAddress("nperalta@scandinavia.com.co");
$mail->AddAddress("apinilla@scandinavia.com.co");
$mail->IsHTML(true); // El correo se envía como HTML
$asunto = "Acceso a Portal de aplicaciones";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = 'Estimado usuario. 
        <br><br>Te informamos que se ha asignado usuario para el acceso al Portal de Aplicaciones, debes realizar los siguientes pasos para acceder al la plataforma. 
                <br><br><ol>
                          <li>Acceder al link: http://appscandinavia.com/scandinavia/seguridad/index.php te recomendamos guardar este link en tus favoritos.</li>
                          <li>Dar clic en &iquest;Olvidaste tu contrase&ntilde;a?.</li>
                          <li>Ingresar tu email corporativo, y dar clic en <img src="http://appscandinavia.com/scandinavia/aplicaciones/boton.png"></li>
                          <li>A tu bandeja de entrada llegar&aacute; un correo de Aplicaciones Scandinavia Pharma con el asunto Actualizaci&oacute;n de Password, el cual contiene un link al cual debes acceder.</li>
                          <li>La plataforma te solicitara definir una nueva contrase&ntilde;a y confirmarla, recuerda que es necesario asignas una contrase&ntilde;a alfanum&eacute;rica de m&aacute;s de 8 caracteres.</li>
                          <li>Luego de haber reestablecido la contrase&ntilde;a podr&aacute;s acceder al link del numeral 1.</li>
                        </ol>
                <br><br>Recuerda que si necesitas soporte para este proceso puedes enviar un correo a lgalindo@scandinavia.com.co.        
                <br><br><br>Cordial saludo,
                <br><br><img src="http://appscandinavia.com/scandinavia/aplicaciones/firma.PNG">';
$mail->Body = $body; // Mensaje a enviar

$mail->Send(); // Envía el correo.




     
                 
          
      







?>