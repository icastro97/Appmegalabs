<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'DocumentID',
	1 => 'razonsocial',
	2 => 'Fecha',
    3 => 'full_name',
	4 => 'valor',
	5 => 'Rechazo'
);

// getting total number records without any search
$sql = "SELECT DocumentID,  razonsocial, Fecha, full_name, Aprobado, ValNeto, Rechazo";
$sql.=" FROM vw_recibostot";
$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT DocumentID,  razonsocial, Fecha, full_name, Aprobado,ValNeto, Rechazo ";
	$sql.=" FROM vw_recibostot";
	$sql.=" WHERE DocumentID LIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR razonsocial LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Fecha LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR full_name LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	$sql = "SELECT DocumentID,  razonsocial, Fecha, full_name, Aprobado,ValNeto, Rechazo ";
	$sql.=" FROM vw_recibostot";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";
if($row["Aprobado"] == "0") { $estadoDoc = "Sin Verificar"; } else { $estadoDoc = $row["Aprobado"]; $verlink = "pdfok";}
	$nestedData=array(); 
	$nestedData[] = $row["DocumentID"];
	$nestedData[] = $row["razonsocial"];
	$nestedData[] = $row["Fecha"];
    $nestedData[] = $row["full_name"]; 
	$nestedData[] = '$'.number_format($row["ValNeto"],2) ; 
	
	   
	$nestedData[] =        $estadoDoc;
	$nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/subefichero.php?id='.$row['DocumentID'].'&op=RC"  data-toggle="tooltip" title="Adjuntar Soportes" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
				     </center></td>';
    $nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/verdocumentos.php?id='.$row['DocumentID'].'&op=RC"  data-toggle="tooltip" title="Ver Documento" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
				     </center></td>';
    $nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/' .$verlink.'.php?rc='.$row['DocumentID'].'&op=RC"  data-toggle="tooltip" title="Ver PDF" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
				     </center></td>';
					 
 $nestedData[] = '<td><center>
                     <a href="/scandinavia/aplicaciones/rc/moddocumentos.php?id='.$row['DocumentID'].'&op=RC&rec='.$row['Rechazo'].'"  data-toggle="tooltip" title="Ver PDF" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
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
