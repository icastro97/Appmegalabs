<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
/**
 * Retorna lista de clientes.
 */
require 'database.php';
require '../../../scandinavia/seguridad/config.php';

$cedula = $_SESSION['identificacion'];

$usr = [];


$sql = "SELECT u_userid, full_name, u_rolecode, cedula from system_users where cedula = ". $cedula;
$prueba = mysqli_query($con, $sql);

$i = 0;

while($row = mysqli_fetch_assoc($prueba))
{
    $usr[$i]['id'] = $row['u_userid'];
    $usr[$i]['nombre'] = $row['full_name'];
    $usr[$i]['rol'] = $row['u_rolecode'];
    $usr[$i]['identificacion'] = $row['cedula'];

}
echo json_encode($usr);



?>