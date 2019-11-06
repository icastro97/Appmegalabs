<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
/**
 * Retorna lista de clientes.
 */
require '../../../../proyecto/api/consulta/database.php';
require '../../../../scandinavia/seguridad/config.php';

$cedula = $_SESSION['identificacion'];

$usr = [];
$i = 0;
$consulta = "SELECT sesion FROM matrizaprobacion where cedulaSesion =".$cedula;
$ejecucion = mysqli_query($con, $consulta);
while ($a = mysqli_fetch_assoc($ejecucion)) {
    $usr[$i]['aprobador'] = $a['sesion'];
}

$sql = "SELECT u_userid, full_name, u_rolecode, cedula from system_users where cedula = ". $cedula;
$prueba = mysqli_query($con, $sql);



while($row = mysqli_fetch_assoc($prueba))
{
    $usr[$i]['id'] = $row['u_userid'];
    $usr[$i]['nombre'] = $row['full_name'];
    $usr[$i]['rol'] = $row['u_rolecode'];
    $usr[$i]['identificacion'] = $row['cedula'];

}
echo json_encode($usr);



?>