<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
session_start();

$id = $_POST['ide'];

echo "ide".$id;


$columns = array( 
// datatable column index  => database column name
	0 => 'id',
    1 => 'tipo', 
	2 => 'cantidad',
	3 => 'nombreAsistente',
	4 => 'cedulaAsistente',
	5 => 'identificadordet',
	6 => 'valor',
	7 => 'transferenciaValor'
);

// getting total number records without any search


	$sql = "SELECT DISTINCT `id`, `tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor, T2.transferenciaValor FROM asistencia_trans_valor LEFT JOIN resultadoCruce T2 ON T2.cedula = cedulaAsistente WHERE identificadordet = '$id'";
	
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-clientes.php: get InventoryItems");
    
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
// if there is a search parameter
	$sql = "SELECT DISTINCT `id`, `tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor, T2.transferenciaValor FROM asistencia_trans_valor LEFT JOIN resultadoCruce T2 ON T2.cedula = cedulaAsistente WHERE identificadordet = '$id' ";
	


	
	
    
    
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get POa"); // again run query with limit
	
} else {	

	
	
	$sql = "SELECT DISTINCT `id`, `tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor, T2.transferenciaValor FROM asistencia_trans_valor LEFT JOIN resultadoCruce T2 ON T2.cedula = cedulaAsistente WHERE identificadordet = '$id'";
   	var_dump($sql);
	$query=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array


//$tempo = " ";  if($row["id"]== "11") { $tempo ="<br><B><blink>Pendiente de su Aprobacion<blink></B>";}
  
	$nestedData=array(); 
	$nestedData[] = $row["id"];
    $nestedData[] = $row['tipo'];
	$nestedData[] = $row["cantidad"];
	$nestedData[] = $row["nombreAsistente"];
	$nestedData[] = $row["cedulaAsistente"];
	$nestedData[] = $row["identificadordet"]; 
	$nestedData[] = $row["valor"];
	$nestedData[] = $row['transferenciaValor'];
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

