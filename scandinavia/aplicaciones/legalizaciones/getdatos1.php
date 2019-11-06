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



$var1 = $_POST['var1'];




$db_handle = new DBController();
$return_arr = array();
$sqlc = "SELECT * FROM `system_users` WHERE u_rolecode IN ('GERENTE ADMINISTRATIVO Y FINANCIERO', 'GERENTE DE DISTRITO', 'JEFE DE TESORERIA', 'GERENTE DE NEGOCIO INSTITUCIONAL', 'GERENTE GENERAL', 'COORDINADORA DE PLANEACION FINANCIERA', 'COORDINADOR DE ASUNTOS', 'COORDINADOR DE TALENTO HUMANO', 'COORDINADOR DE VENTAS INSTITUCIONAL', 'COORDINADORA DE PLANEACION FINANCIERA', 'COORDINADORA DE TRADE', 'COORDINADORA SEGURIDAD Y SALUD EN EL TRABAJO', 'GERENTE DE LINEA', 'GERENTE DE LINEA OTC', 'GERENTE DE NEGOCIO INSTITUCIONAL', 'JEFE COMERCIAL', 'JEFE DE ACCESO', 'JEFE DE ASEGURAMIENTO DE CALIDAD', 'JEFE DE ASUNTOS REGULATORIOS', 'JEFE DE COMPRAS', 'JEFE DE CONTABILIDAD', 'JEFE DE GESTION DE CALIDAD', 'JEFE DE INVESTIGACION Y DESARROLLO', 'JEFE DE LOGISTICA', 'JEFE DE TECNOLOGIA Y INFORMATICA', 'JEFE DE TESORERIA', 'JEFE DPTO DE CARTERA', 'JEFE INSTITUCIONAL', 'GERENTE PRODUCTO', 'VENDEDOR COMERCIAL', 'GERENTE TALENTO HUMANO'  ) and full_name LIKE '%".$var1. "%' GROUP BY u_userid"; 
$faq = $db_handle->runQuery($sqlc);


$obj = array();


foreach($faq as $k=>$v) {
    
    
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
    $limpiar = eliminar_tildes($faq[$k]['full_name']);
    
    $obj['full_name']= $limpiar;
    $obj['cedula']= $faq[$k]['cedula'];
    $obj['u_userid']= $faq[$k]['u_userid'];
}

echo json_encode($obj);

