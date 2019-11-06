<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'id_cabeza',
    1 => 'tipolegalizacion', 
	2 => 'fecha',
	3 => 'nombre',
	4 => 'linea',
	5 => 'area',
	6 => 'regional' 
);
function eliminar_tildes($cadena){
 
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    $cadena = utf8_encode($cadena);
 
    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );
 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );
 
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );
 
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );
 
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );
 
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );
 
    return $cadena;
}
// getting total number records without any search
$sql = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado, T1.observaciones";
$sql.=" FROM lg_cabeza T1  INNER JOIN  empleadolg T2 ON  T1.identificacion = T2.cedula where estado <> '0'";  

$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.linea, T1.area, T1.estado, T2.regional, T1.nombre";
	$sql.=" FROM lg_cabeza T1  INNER JOIN  empleadolg T2 ON  T1.identificacion = T2.cedula "; 
	$sql.=" WHERE estado <> '0' and T1.id_cabeza LIKE '".$requestData['search']['value']."%'  ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR tipolegalizacion LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR fecha LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR linea LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR area LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR estado LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR nombre LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR regional LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	$sql = "SELECT T1.id_cabeza, T1.tipolegalizacion, T1.fecha, T1.nombre, T1.linea, T1.area, T2.regional, T1.estado, T1.observaciones";
    $sql.=" FROM lg_cabeza T1  INNER JOIN  empleadolg T2 ON  T1.identificacion = T2.cedula where estado <> '0'";  
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$verlink = "pdf";
	if($row["estado"] == "1") { $estadoDoc = "Sin Verificar"; } else { $estadoDoc = $row["estado"]; $verlink = "pdfok";}
	$limpiacargo = eliminar_tildes($row['tipolegalizacion']);
	$limpiacargo2 = eliminar_tildes($row['observaciones']);
	$nestedData=array(); 
	$nestedData[] = $row["id_cabeza"];
	$nestedData[] = $limpiacargo;
	$nestedData[] = $row["fecha"];
	$nestedData[] = $row["nombre"];
	$nestedData[] = $row["linea"];
	$nestedData[] = $row["area"];
	$nestedData[] = $row["regional"];
	$nestedData[] = $limpiacargo2;
	$nestedData[] =        $estadoDoc;
	if($row["estado"] != "50"){
		$nestedData[] = '<td ><center>                 
						 <a href="/scandinavia/aplicaciones/legalizaciones/verdocumentosg.php?id='.$row['id_cabeza'].'&op=LG"   title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i> </a>                     
						</center></td>';
		}else{
		$nestedData[] = '<td><center>	                 
						 <a href="#"  data-toggle="tooltip" title="Soportes" class="btn btn-sm btn-primary"> <i class="menu-icon icon-search"></i> </a>                     
						 </center></td>';	
		}
		
		$nestedData[] = '<td ><center>
						 <a href="/scandinavia/aplicaciones/legalizaciones/verdocumentosg.php?id='.$row['id_cabeza'].'&op=LG"   title="Ver Documento" class="btn"  style="background-color:#00AB84;"> </a>                     
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