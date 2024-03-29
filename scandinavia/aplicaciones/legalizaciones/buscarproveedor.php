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



if (isset($_GET['term'])){
	# conectare la base de datos


$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT  * FROM proveedores WHERE  NIT like '".$_GET['term']."%' LIMIT 10";

$faq = $db_handle->runQuery($sqlc);


/*

$mysqli = new mysqli('localhost', 'root', '' , 'app');


	$sql = "SELECT * FROM proveedores WHERE NIT LIKE '%".$_GET['term']."%'	LIMIT 10"; 
	$faq = $mysqli->query($sql);
	
*/

$return_arr = array();


foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	$row_array['value'] = $faq[$k]['NIT'];
	$row_array['Nombres']=$faq[$k]['NIT'];
	$row_array['idx']=$faq[$k]['razonsocial'];

	
	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>
