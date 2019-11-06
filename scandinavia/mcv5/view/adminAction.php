<?php

require_once '../../mcv5/clases/DB.class.php';

$nombreUsuario = $_POST['username'];
$contraseña = $_POST['password'];
$nombre = $_POST['fullname'];
$rol = $_POST['rol'];
$cedula = $_POST['identificacion'];
$email = $_POST['email'];


$sql="INSERT INTO `system_users`( `u_username`, `u_password`, `full_name`, `u_rolecode`, `created`, `modified`, `status`, `remember_key`, `forgot_pass_identity`, `email`, `cedula`, `ubicacionFirma`) VALUES ('$nombreUsuario', '$contraseña','$nombre','$rol', null,null,null,null,null,'$email','$cedula','')";
$query = mysqli_query($mysqli, $sql);
if($query)
{
     
    $to = $email;
    $subject = "Usuario creado";
    $mailContent = 'Estimado(a) '.$nombre.', 
    <br>Se creo satisfactoriamente el usuario '.$nombreUsuario.'
    <br><br>Saludos';
    //set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    //$headers = "MIME-Version: 1.0" . "rn";
    //$headers .= "Content-type:text/html;charset=UTF-8" . "rn";
    //additional headers
    //$headers .= 'From: Tu<[email protected]>' . "rn";
    $headers .='From: Aplicaciones Scandinavia Pharma <no-reply@appscandinavia.com>';
    //send email
    mail($to,$subject,$mailContent,$headers);
    echo "<script type='text/javascript'>window.top.location='http://appscandinavia.com/scandinavia/mcv5/admin.php';</script>";
}
else
{
    echo "no insertado";
    //var_dump(mysqli_error($mysqli));
}


?>