<?php
class DBController {
	private $host = "localhost";
	private $user = "scandapp_app";
	private $password = "Qwerty1234$";
	private $database = "scandapp_app";
	private $conn;
	
function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_array($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset))
			return $resultset;
	}
	
	function insertQuery($query) {
	    mysqli_query($this->conn, $query);
	    $insert_id = mysqli_insert_id($this->conn);
	    return $insert_id;
	}
	
	function getIds($query) {
	    $result = mysqli_query($this->conn,$query);
	    while($row=mysqli_fetch_array($result)) {
	        $resultset[] = $row[0];
	    }
	    if(!empty($resultset))
	        return $resultset;
	}
	
   function numRows($query) {
        $result  = mysqli_query($this->conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
}




function eliminar_tildes($cadena){
 
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    $cadena = utf8_encode($cadena);
 
    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );
 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );
 
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );
 
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );
 
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );
 
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );
 
    return $cadena;
}


if (isset($_GET['term'])){
	# conectare la base de datos


$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT u_userid, cedula, full_name FROM system_users WHERE u_rolecode IN ('JEFE DE ASEGURAMIENTO DE CALIDAD', 'ASISTENTE DE MERCADEO', 'ASISTENTE DE NEGOCIO', 'ASISTENTE GERENCIA DE PROMOCION Y VENTAS', 'WEBMASTER', 'ANALISTA DE COMPRAS DE MARKETING Y GENERALES', 'ANALISTA CRM MEDICOS', 'COORDINADOR DE TALENTO HUMANO', 'GERENTE DE DISTRITO', 'ANALISTA DE COMPRAS DE MATERIAL DE ENVASE Y EMPAQU', 'ASISTENTE DE LOGISTICA', 'ASISTENTE DE CALIDAD', 'JEFE DE TECNOLOGIA Y INFORMATICA', 'JEFE DE CONTABILIDAD', 'GERENTE ADMINISTRATIVO Y FINANCIERO', 'ANALISTA DE COSTOS', 'DIRECTOR TECNICO', 'ANALISTA DE INVENTARIOS Y LOGISTICA', 'ASISTENTE DE INVESTIGACION Y DESARROLLO', 'COORDINADORA SEGURIDAD Y SALUD EN EL TRABAJO', 'JEFE DE COMPRAS', 'GERENTE TALENTO HUMANO', 'JEFE DE GESTION DE CALIDAD', 'JEFE DE PRODUCCION', 'ANALISTA EXPORTACIONES', 'ANALISTA DE IMPORTACIONES DE PRODUCTO TERMINADO', 'COORDINADOR DE NOMINA', 'ASISTENTE TALENTO HUMANO', 'JEFE SERVICIO AL CLIENTE', 'JEFE COMERCIAL', 'ANALISTA DE COMPRAS', 'COORDINADOR DE ASUNTOS','ANALISTA ASEGURAMIENTO DE LA CALIDAD', 'ASISTENTE CONTROL DE CALIDAD', 'COORDINADORA DE PRODUCCION', 'JEFE INTELIGENCIA DE NEGOCIOS', 'COORDINADORA  REGULATORIO DE CALIDAD', 'ASISTENTE DE ASUNTOS', 'RECEPCIONISTA', 'JEFE DPTO DE CARTERA','JEFE DE LOGISTICA', 'ASISTENTE DE DIRECCION', 'COORDINADORA DE ASEGURAMIENTO DE LA CALIDAD')  and full_name like '%".$_GET['term']."%' GROUP BY u_userid LIMIT 10";
//var_dump($sqlc);

$faq = $db_handle->runQuery($sqlc);


$return_arr = array();


foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/

$limpiarcargo = eliminar_tildes($faq[$k]['full_name']);
	
$row_array['value'] = $limpiarcargo;
$row_array['id'] = $faq[$k]['u_userid'];
$row_array['cedula'] = $faq[$k]['cedula'];
	

	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>

