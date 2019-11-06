<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'Cliente',
    1 => 'NIT'
);

// getting total number records without any search
$sql = "SELECT Cliente, NIT ";
$sql.=" FROM vw_grillaclientesbasec";
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT Cliente, NIT ";
	$sql.=" FROM vw_grillaclientesbasec";
	$sql.=" WHERE Cliente LIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter	
	$sql.=" OR NIT LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	$sql = "SELECT Cliente, NIT";
	$sql.=" FROM vw_grillaclientesbasec";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["Cliente"]; 
    $nestedData[] = $row["NIT"];
    $nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/documentos.php?id='.$row['NIT'].'&op=RC"  data-toggle="tooltip" title="Ver Facturas" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
				     </center></td>';
	$nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/ranticipo.php?id='.$row['NIT'].'&op=GRILLA ANTICIPOS" data-toggle="tooltip" title="Ver Facturas" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
				     </center></td>';
	
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
