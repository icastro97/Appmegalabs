<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name
	0 => 'codigo',
    1 => 'nombremedico', 
	6 => 'tratamientoDatos',
	7 => 'publicidad',
	8 => 'materialCientifico',
	9 => 'transferenciaValor'
);



	$sql = "SELECT * FROM `resultadoCruce` where cedula = 1019031699"; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-clientes.php: get InventoryItems");
    
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {

	
} else {	

	
	
	$sql = "SELECT * FROM `resultadoCruce` where cedula = 1019031699";
   	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
  	 
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array


//$tempo = " ";  if($row["id"]== "11") { $tempo ="<br><B><blink>Pendiente de su Aprobacion<blink></B>";}
  
	$nestedData=array(); 
	$nestedData[] = $row["codigo"];
	$nestedData[] = $row["nombremedico"];
	$nestedData[] = $row["tratamientoDatos"];
	$nestedData[] = $row["publicidad"];
	$nestedData[] = $row["materialCientifico"];
	$nestedData[] = $row["transferenciaValor"]; 
	
		$nestedData[] = '<td><center>	                 
						 <a href="/scandinavia/aplicaciones/firma/tipocon.php" data-toggle="tooltip" title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a> ';                    
	   				 			
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

