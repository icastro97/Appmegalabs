<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */
session_start();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'consecutivo',
    1 => 'tipo', 
	2 => 'fechaActual',
	3 => 'identificacion',
	4 => 'nombre'
	
    
);




// getting total number records without any search
$sql = "SELECT consecutivo, tipo, fechaActual, identificacion, nombre, estado FROM consecutivomayor where nombre <> 'Marketing farmaceutico SAS' and  nombre <> 'invima' ";

$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) { 
	// if there is a search parameter
	$sql = "SELECT consecutivo, tipo, fechaActual, identificacion, nombre, estado FROM consecutivomayor";
	$sql.=" WHERE T1.consecutivo LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR T1.tipo LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR T1.fechaActual LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR T1.identificacion LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR T1.nombre LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR T1.estado LIKE '%".$requestData['search']['value']."%' ";
	
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	$sql = "SELECT consecutivo, tipo, fechaActual, identificacion, nombre, estado FROM consecutivomayor where  nombre <> 'Marketing farmaceutico SAS' and  nombre <> 'invima' ";

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";
if($row["estado"] == "1") { $estadoDoc = "Sin Verificar"; } else { $estadoDoc = $row["estado"]; $verlink = "pdfok";} 
	$nestedData=array(); 
	$nestedData[] = $row["consecutivo"];
    $nestedData[] = $row["tipo"];
	$nestedData[] = $row["fechaActual"];
	$nestedData[] = $row["identificacion"];
	$nestedData[] = $row["nombre"];
        
	$nestedData[] =        $estadoDoc;
	
		if($row["estado"] != "50"){
		$nestedData[] = '<td><center>	                 
						<a href="/scandinavia/aplicaciones/Anticipos/verDocumentosCheckGerencia.php?id='.$row['consecutivo'].'&op=LG&cedula='.$row['identificacion'].'"   title="Soportes" class="btn" style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i> </a>                     
						</center></td>';
		}else{
		$nestedData[] = '<td><center>	                 
						<a href="#"  data-toggle="tooltip" title="Soportes" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
						</center></td>';	
		}
		
		$nestedData[] = '<td><center>
						<a href="/scandinavia/aplicaciones/Anticipos/verDocumentosCheckGerencia.php?id='.$row['consecutivo'].'&op=LG&cedula='.$row['identificacion'].'"   title="Ver Documento" class="btn "> <i class="menu-icon glyphicon glyphicon-search"></i> </a>                     
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