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

$var1 = $_POST['codigo'];




$db_handle = new DBController();
$return_arr = array();
$sqlc = "SELECT  tipo, cedula, nombrep,nombres,apellidop,apellidos,correo,telefono, ciudad  FROM formulario_firma2 WHERE  codigo = ".$var1;

$faq = $db_handle->runQuery($sqlc);


$obj = array();


foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	
	$obj['value2'] = $faq[$k]['tipo'];
	$obj['value3'] = $faq[$k]['cedula'];
	$obj['value4'] = $faq[$k]['nombrep'];
	$obj['value5'] = $faq[$k]['nombres'];
	$obj['value6'] = $faq[$k]['apellidop'];
	$obj['value7'] = $faq[$k]['apellidos'];
	$obj['value8'] = $faq[$k]['correo'];
	$obj['value9'] = $faq[$k]['telefono'];
	$obj['value10'] = $faq[$k]['ciudad'];
	

	

}
/* Codifica el resultado del array en JSON. */
echo json_encode($obj);