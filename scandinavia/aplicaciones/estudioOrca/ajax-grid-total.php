<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$cedula = $_POST['cedula'];

session_start();


$columns = array( 
// datatable column index  => database column name
	0 => 'id_formularioc',
	1 => 'estudio',
	2 => 'fechaActual',
    3 => 'nombreMedico', 
	4 => 'ciudad',
	5 => 'codigoPaciente',
	5 => 'archivo'
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


	$sql = "SELECT `id_formularioc`, `estudio`, `fechaActual`, `nombreMedico`, `ciudad`, `codigoPaciente`,archivo FROM `formulariochaco`";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT `id_formularioc`, `estudio`, `fechaActual`, `nombreMedico`, `ciudad`, `codigoPaciente`,archivo FROM `formulariochaco` where id_formularioc LIKE '%".$requestData['search']['value']."%'";
	$sql.=" OR id_formularioc LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR estudio LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR fechaActual LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR nombreMedico LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR ciudad LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR codigoPaciente LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO"); // again run query with limit
	
} else {	

	
	
	$sql = "SELECT `id_formularioc`, `estudio`, `fechaActual`, `nombreMedico`, `ciudad`, `codigoPaciente`, archivo FROM `formulariochaco`";
   	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get PO");
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$verlink = "pdf";

//$tempo = " ";  if($row["id"]== "11") { $tempo ="<br><B><blink>Pendiente de su Aprobacion<blink></B>";}
	$nestedData=array(); 
	$nombremedico = eliminar_tildes($row["nombreMedico"]);
	$nestedData[] = $row["id_formularioc"];	
	$nestedData[] = $row["estudio"];
	$nestedData[] = $row["fechaActual"];
    $nestedData[] = $nombremedico;
	$nestedData[] = $row["ciudad"];
	$nestedData[] = $row["codigoPaciente"];
	if($row['estudio'] == "Epi-ERGE"){
		$nestedData[] = '<td><center>	                 
						 <a href="https://appmegalabs.com/scandinavia/aplicaciones/estudioErge/verdocumentos.php?estudio='.$row['estudio'].'&id='.$row['id_formularioc'].'" data-toggle="tooltip" title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
						 </center></td>';
		}else if($row['estudio'] == "CHACO"){
		$nestedData[] = '<td><center>	                 
						 <a href="https://appmegalabs.com/scandinavia/aplicaciones/estudioChaco/verdocumentos.php?estudio='.$row['estudio'].'&id='.$row['id_formularioc'].'"  data-toggle="tooltip" title="Soportes" class="btn" style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i> </a>                     
						 </center></td>';	
		}
		
		$nestedData[] = '<td><center>
						 <a href="https://appmegalabs.com/scandinavia/aplicaciones/estudioOrca/verdocumentos.php?estudio='.$row['estudio'].'&id='.$row['id_formularioc'].'" data-toggle="tooltip" title="Ver Documento" class="btn" style="background-color:#00AB84;"><i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>   </a>                     
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

