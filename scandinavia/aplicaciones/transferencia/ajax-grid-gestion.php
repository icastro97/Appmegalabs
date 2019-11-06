<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
session_start();
$sesion = $_POST['sesion'];

$columns = array( 
// datatable column index  => database column name
	0 => 'id_transferencia',
    1 => 'fecha_registro', 
	2 => 'establecimiento',
	3 => 'descripcion'
);

// getting total number records without any search
	$sql = "SELECT id_transferencia, fecha_registro, establecimiento, descripcion, estado FROM transferencia_val ";
	
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");


$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	
	
} else {	

	
	$sql = "SELECT id_transferencia, fecha_registro, establecimiento, descripcion, estado FROM transferencia_val";
	
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";
if($row["estado"] == "1") { $estadoDoc = "En proceso"; }else if($row["estado"] == "2"){$estadoDoc = "Sin distribuir";} else { $estadoDoc = $row["estado"]; $verlink = "pdfok";}

	$nestedData=array(); 
    $nestedData[] = $row["id_transferencia"];
    $nestedData[] = $row["fecha_registro"];
    $nestedData[] = $row["establecimiento"];
    $nestedData[] = $row["descripcion"];
	$nestedData[] = $estadoDoc ;
	if($row["estado"] != "NO ACEPTO" && $row['estado'] != "REC" && $row['estado'] != "2" ){
		$nestedData[] = '<td><center>	                 
						 <a href="verdocumentos.php?documento='.$row['id_transferencia'].'"   title="Ver Documento" class="btn" style="background-color:#00AB84;"><i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
						 </center></td>';
		}else{
			$nestedData[] = '<td><center>	                 
			<a href="rehacer.php?documento='.$row['id_transferencia'].'"   title="Ver Documento" class="btn" style="background-color:#00AB84;"><i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
			</center></td>'; 
		
	}
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
