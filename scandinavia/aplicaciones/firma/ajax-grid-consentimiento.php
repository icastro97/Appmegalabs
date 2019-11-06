<?php

require_once '../../mcv5/clases/DB.class.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
session_start();

$cedula = $_POST['cedula'];




$columns = array( 
// datatable column index  => database column name
	0 => 'id_cliente',
	1 => 'Cliente',
	2 => 'codigo'
);

// getting total number records without any search


	$sql = "SELECT distinct T1.id_cliente, T1.Cliente, T2.tratamientoDatos, T2.publicidad, T2.materialCientifico, T2.transferenciaValor FROM `medicos` T1 LEFT JOIN formulario_firma T2 ON T2.codigo = T1.id_cliente where cedula_usuario =".$cedula;
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-cliente.php: get InventoryItems");
	$totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
// if there is a search parameter
	$sql = "SELECT id_cliente, cliente from medicos ";
	$sql.=" WHERE  cedula_usuario = $cedula and id_cliente LIKE '".$requestData['search']['value']."' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR cliente LIKE '%".$requestData['search']['value']."%' ";
	$query=mysqli_query($mysqli, $sql) or die("ajax-grid-data.php: get PO");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 


   
	
} else {	

	
	
	$sql = "SELECT distinct T1.id_cliente, T1.Cliente, T2.tratamientoDatos, T2.publicidad, T2.materialCientifico, T2.transferenciaValor FROM `medicos` T1 LEFT JOIN formulario_firma T2 ON T2.codigo = T1.id_cliente where cedula_usuario =".$cedula;
    $sql.=" GROUP BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($mysqli, $sql) or var_dump(mysqli_error($mysqli));
	
	
	
}

$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 

    
    $nestedData[] = $row["id_cliente"];
    $nestedData[] = $row["Cliente"];
    $consulta = "select MAX(id_consentimiento) as maximoConsentimiento from formulario_firma2 where tipo2 = 'Ad' and codigo = ". $row['id_cliente'];
    $ejecucion = mysqli_query($mysqli, $consulta);
    
    while($rows = mysqli_fetch_array($ejecucion))
    {
        $maximoConsentimiento = $rows['maximoConsentimiento'];
    }
    
    $consultad = "select MAX(id_consentimiento) as maximoConsentimiento from formulario_firma2 where tipo2 = 'Tv' and codigo = ". $row['id_cliente'];
    $ejecuciones = mysqli_query($mysqli, $consultad);
    
    while($rowss = mysqli_fetch_array($ejecuciones))
    {
        $maximoConsentimiento1 = $rowss['maximoConsentimiento'];
    }
    
    
    $consulta2 = "SELECT * FROM formulario_firma2 where id_consentimiento in ( ".$maximoConsentimiento.", ".$maximoConsentimiento1.")";
    var_dump($consulta2);
    $ejecutar = mysqli_query($mysqli, $consulta2);
    
    while($fila = mysqli_fetch_array($ejecutar))
    {
        $con = $fila['id_consentimiento'];
        $tDatos = $fila['tratamientoDatos'];
        $pub = $fila['publicidad'];
        $cientifico = $fila['materialCientifico'];
        $tValor = $fila['transferenciaValor'];
        $documentoF = $fila['adjunto'];
        $pdfs = $fila['pdf'];
    }
    
	if($con == '') 
	{
	    $sqls = "SELECT * FROM formulario_firma where codigo = ".$row['id_cliente']." ";
	    
	    $eje = mysqli_query($mysqli, $sqls);
	    $num = mysqli_num_rows($eje);
	    while($file = mysqli_fetch_array($eje))
	    {
	        $id_c = $file['id_consentimiento'];
	        $tratamiento = $file['tratamientoDatos'];
	        $publicidad = $file['publicidad'];
	        $materialCientifico = $file['materialCientifico'];
	        $transferenciaValor = $file['transferenciaValor'];
	        $pdf = $file['pdf'];
	        $documentoFisico = $file['adjunto'];
       
    	      if($id_c != NULL)
            	 {
                	$nestedData[] = $tratamiento;
                	$nestedData[] = $publicidad;
                	$nestedData[] = $materialCientifico;
                	$nestedData[] = $transferenciaValor;
                	if($pdf || $documentoFisico)
                	{
                	    if($pdf != null)
                	    {
                	        $nestedData[] = '<td><center>	                 
            						 <a href="/scandinavia/aplicaciones/firma/'.$pdf.'" target="_blank" data-toggle="tooltip" title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
            						 </center></td> electronico'.$id_c;  
            						 
                	    }
                	    else 
                	    {
                	        
                	        $nestedData[] = '<td><center>	                 
            						 <a href="/scandinavia/aplicaciones/firma/documentosFisicos/'.$documentoFisico.'"  target="_blank" data-toggle="tooltip" title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
            						 </center></td>fisico'.$id_c;   
                	        
                	    }
                	    
                	  
                	}
                	
                	else
                	{      
                	    $nestedData[] = "";
                	    $nestedData[] = "";
                	    $nestedData[] = "";
                	    $nestedData[] = "";
                	    $nestedData[] = "No tiene consentimiento";
                	}
            	 } 	
            	else
            	{
            	    
            	    $nestedData[] = $tDatos;
            	    $nestedData[] = $pub;
            	    $nestedData[] = $cientifico;
            	    $nestedData[] = $tValor;
            	    if($documentoF || $pdfs)
            	    {
            	        $nestedData[] = '<td><center>	                 
            						 <a href="/scandinavia/aplicaciones/legalizaciones/verdocumentos.php?id='.$id_c.'" data-toggle="tooltip" title="Soportes" class="btn"  style="background-color:#00AB84;"> <i class="menu-icon glyphicon glyphicon-search" style="color:white;"></i>  </a>                     
            						 </center></td> aqui';    
            	    }
            	    else
            	    {
            	        
            	    }
            	    
            	}
    	}
    	
    	
               
        	
        	
    
	    

	}
	else
	{
	    $nestedData[] = $tDatos;
    	$nestedData[] = $pub;
    	$nestedData[] = $cientifico;
    	$nestedData[] = $tValor;
	    $nestedData[] = 'asdsad';
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

