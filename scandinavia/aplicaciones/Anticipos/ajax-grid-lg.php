<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */
session_start();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$identifi = $_SESSION['identificacion'];
$usuario = $_POST['usuario'];
$aprobador = $_POST['id_app'];
$sesion = $_SESSION["user_id"];

$columns = array( 
// datatable column index  => database column name
	0 => 'consecutivo',
    1 => 'tipo', 
	2 => 'fechaActual',
	3 => 'identificacion',
	4 => 'nombre'
	
    
);




// getting total number records without any search
$sql = "SELECT T1.consecutivo, T1.tipo, T1.fechaActual, T1.identificacion, T1.nombre, T1.estado FROM anticipo T1 INNER JOIN system_users T2 WHERE IF( T1.estado = '0', '', T1.aprobador = $usuario OR T1.identificacion = $identifi OR T1.userid = $sesion ) GROUP BY T1.consecutivo order by T1.estado asc";

$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) { 
	// if there is a search parameter
	$sql = "SELECT T1.consecutivo, T1.tipo, T1.fechaActual, T1.identificacion, T1.nombre, T1.estado FROM anticipo T1 ";
	$sql.=" WHERE IF( T1.estado = '0', '', T1.aprobador = $usuario OR T1.identificacion = $identifi OR T1.userid = $sesion ) and T1.consecutivo LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" GROUP BY T1.consecutivo ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	$sql = "SELECT T1.consecutivo, T1.tipo, T1.fechaActual, T1.identificacion, T1.nombre, T1.estado FROM anticipo T1 INNER JOIN system_users T2 WHERE IF( T1.estado = '0', '', T1.aprobador = $usuario OR T1.identificacion = $identifi OR T1.userid = $sesion ) GROUP BY T1.consecutivo";
	$sql.=" ORDER BY T1.estado asc, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
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
						<a href="/scandinavia/aplicaciones/Anticipos/verdocumentosP.php?id='.$row['consecutivo'].'&op=LG&cedula='.$row['identificacion'].'"   title="Soportes" class="btn" style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i> </a>                     
						</center></td>';
		}else{
		$nestedData[] = '<td><center>	                 
						<a href="#"  data-toggle="tooltip" title="Soportes" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
						</center></td>';	
		}
		
		$nestedData[] = '<td><center>
						<a href="/scandinavia/aplicaciones/Anticipos/verdocumentosP.php?id='.$row['consecutivo'].'&op=LG&cedula='.$row['identificacion'].'"   title="Ver Documento" class="btn "> <i class="menu-icon glyphicon glyphicon-search"></i> </a>                     
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
