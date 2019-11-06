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




$var1 = $_POST['var1'];




$db_handle = new DBController();
$return_arr = array();
$sqlc = "SELECT * FROM `medicos` WHERE Cliente LIKE '%".$var1."%' GROUP BY id_cliente"; 

$faq = $db_handle->runQuery($sqlc);


$obj = array();


foreach($faq as $k=>$v) {
    
    
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
    
    $obj['Cliente']= $faq[$k]['Cliente'];
    $obj['cedula_usuario']= $faq[$k]['cedula_usuario'];
    $obj['usuario']= $faq[$k]['usuario'];
    $obj['id_cliente']= $faq[$k]['id_cliente'];
}

echo json_encode($obj);

