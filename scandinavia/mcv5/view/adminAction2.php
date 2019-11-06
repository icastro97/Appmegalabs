<?php

require_once '../../mcv5/clases/DB.class.php';

$nombreUsuario = $_POST['username'];
$contraseña = $_POST['password'];
$nombre = $_POST['fullname'];
$rol = $_POST['rol'];
$cedula = $_POST['cedulaSesion'];
$email = $_POST['email'];


$sql="UPDATE `system_users` SET  `u_rolecode`='$rol' WHERE cedula =".$cedula;

$query = mysqli_query($mysqli, $sql);

if($query)
{
    echo "actualizado";
}
else
{
    echo "asdas";
}


?>