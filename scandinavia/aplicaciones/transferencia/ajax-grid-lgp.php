<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
session_start();
$usr = $_SESSION['id'];
$identificacion = $_SESSION['identificacion'];

$columns = array( 
// datatable column index  => database column name
	0 => 'id_transferencia',
	1 => 'fecfact',
	2 => 'establecimiento',
	3 => 'estado'	
 
);

// getting total number records without any search
$sql = "SELECT T1.id_transferencia, T1.fecfact, T1.establecimiento, T1.estado, T1.user_id, T1.descripcion FROM `transferencia_val` T1  where estado IN ('1','ACEPTADO', 'APR') and aprobador = $usr group by T1.id_transferencia";
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT T1.id_transferencia, T1.fecfact, T1.establecimiento, T1.estado, T1.user_id, T1.descripcion FROM `transferencia_val` T1 ";
	$sql.=" WHERE id_transferencia LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR fecfact LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR establecimiento LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR estado LIKE '%".$requestData['search']['value']."%' and user_id = $usr ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	
	$sql = "SELECT T1.id_transferencia, T1.fecfact, T1.establecimiento, T1.estado, T1.user_id, T1.descripcion FROM `transferencia_val` T1 where estado IN ('1','ACEPTADO', 'APR') and aprobador = $usr group by T1.id_transferencia";
	
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";
if($row["estado"] == "1") { $estadoDoc = "Pendiente"; } else { $estadoDoc = $row["estado"]; $verlink = "pdfok";}
	$nestedData=array(); 
	$nestedData[] = $row["id_transferencia"];
    $nestedData[] = $row["fecfact"];
	$nestedData[] = $row["establecimiento"];
	$nestedData[] = $row["descripcion"];
    $nestedData[] = $estadoDoc;
	if($row["estado"] == "APR"){
		$nestedData[] = '<td><center>	                 
						 <a href="/scandinavia/aplicaciones/transferencia/deTransferencia2.php?documento='.$row['id_transferencia'].'" class="btn" style="background-color:#00AB84;"><i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
						 </center></td>';
		}else{
	$nestedData[] = '<td><center>	                 
						 <a href="/scandinavia/aplicaciones/transferencia/deTransferencia.php?documento='.$row['id_transferencia'].'" class="btn" style="background-color:#00AB84;"><i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
						 </center></td>';	
		}
		
		$nestedData[] = '<td><center>
						 <a href="/scandinavia/aplicaciones/transferencia/deTransferencia.php?documento='.$row['id_transferencia'].'"class="btn" style="background-color:#00AB84;"></a>                     
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
