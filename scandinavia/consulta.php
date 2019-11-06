
<?php	

require('mcv5/clases/DB.class.php');
// Procesamos en envio desde el input via POST
$palabraclave = strval($_POST['busqueda']);
$busqueda = "{$palabraclave}%";
// Realizamos la conexión MySQLi
//$conexion =new mysqli('localhost', 'root', '' , 'app');
// Preparamos la consulta para realizar la busqueda del criterio
$consultaDB = $mysqli->prepare("select a.id, a.mod_modulegroupcode,a.mod_modulegroupname, a.mod_modulecode, a.mod_modulename, a.mod_modulepagename,  a.icon,b.rr_rolecode, b.status, 
c.u_userid, c.full_name, c.u_rolecode FROM module a inner join role_rights b on a.mod_modulecode = b.rr_modulecode 
inner join system_users c on c.u_rolecode = b.rr_rolecode 
where c.u_userid = 3 and a.mod_modulename LIKE ? order by a.mod_modulegrouporder ");
$consultaDB->bind_param("s",$busqueda);			
$consultaDB->execute();
$resultado = $consultaDB->get_result();
// Condicional para tratar a los resultados encontrados
if ($resultado->num_rows > 0) {
	while($registros = $resultado->fetch_assoc()) {
	// Llamando a la columna Pais_Nombre
	$varurl = "<a href=" . $registros["mod_modulepagename"] . "> " . $registros["mod_modulename"] . " </a>";
	$ResultadoPais[] = $varurl;
	}
	echo json_encode($ResultadoPais);
	}
// Cerramos la conexión con el servidor
$consultaDB->close();
?>

