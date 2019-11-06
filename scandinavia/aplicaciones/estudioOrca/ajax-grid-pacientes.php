<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$cedula = $_POST['cedula'];

session_start();


$columns = array( 
// datatable column index  => database column name
	0 => 'id_paciente',
	1 => 'estudio',
	2 => 'codigoPaciente',
    3 => 'cedulaMedico', 
	4 => 'nombreMedico'
);

// getting total number records without any search


	$sql = "SELECT `id_paciente`, `estudio`, `codigoPaciente`, `cedulaMedico`, `nombreMedico` FROM `pacientes`";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT `id_paciente`, `estudio`, `codigoPaciente`, `cedulaMedico`, `nombreMedico` FROM `pacientes` where id_paciente = '%".$requestData['search']['value']."%' ";
	$sql.=" OR id_paciente LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR estudio LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR codigoPaciente LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR cedulaMedico LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR nombreMedico LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	
	
	$sql = "SELECT `id_paciente`, `estudio`, `codigoPaciente`, `cedulaMedico`, `nombreMedico` FROM `pacientes`";
   	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";

//$tempo = " ";  if($row["id"]== "11") { $tempo ="<br><B><blink>Pendiente de su Aprobacion<blink></B>";}
	$nestedData=array(); 
	
	$nestedData[] = $row["id_paciente"];	
	$nestedData[] = $row["estudio"];
	$nestedData[] = $row["codigoPaciente"];
    $nestedData[] = $row["cedulaMedico"];
	$nestedData[] = $row["nombreMedico"];
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

