<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require ('../../scandinavia/aplicaciones/legalizaciones/phpmailer/class.phpmailer.php');

  
  $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
  
  require("precios/database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
  
  $sql ="INSERT INTO `medicosObjetivo`(`Nombre`, `documento`, `direccion`, `correo`, `telefono`, `tratamiento`) VALUES ('$params->Nombre','$params->Documento','$params->Direccion','$params->Correo','$params->Telefono','$params->IsAccepted')";
  // REALIZA LA QUERY A LA DB
 $res = mysqli_query($con, $sql);  
  class Result {}
  if($res == true){
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
            $mail->AddAddress("$params->Correo"); // Esta es la dirección a donde enviamos
            
            $mail->IsHTML(true); // El correo se envía como HTML
            $asunto = "Tratamiento de Datos";
            $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
            $body = " Estimado/a  $params->Nombre, <br><br>
            Usted ha ingresado informacion personal a la plataforma de appmegalabs.com autorizando a SCANDINAVIA PHARMA LTDA a administrar sus datos personales deacuerdo con la ley 1581 de el 2012<br>
            SCANDINAVIA PHARMA  ha dispuesto los siguientes links en cumplimiento de la ley 1581 de el 2012<br>
            <a href ='http://appmegalabs.com/scandinavia/aplicaciones/video/Politicas.php '>Politica tratamiento Datos Personales</a><br>
            <a href='http://appmegalabs.com/scandinavia/aplicaciones/video/baja.php'>Revocar Tratamiento de datos Personales</a>
            <br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
            $mail->Body =utf8_decode($body); // Mensaje a enviar
            $mail->Send(); // Envía el correo.
      
      
    $response = new Result();
    $response->resultado = 'OK';
  }
  else{
    $response = new Result();
    $response->resultado = 'Error';
  }
  // GENERA LOS DATOS DE RESPUESTA

  header('Content-Type: application/json');
 echo json_encode($response); // MUESTRA EL JSON GENERADO