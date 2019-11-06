<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
    require 'database.php';
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];
    if(isset($_FILES['imagenPropia'])){

		$imagen_tipo = $_FILES['imagenPropia']['type'];
		$imagen_nombre = $_FILES['imagenPropia']['name'];
		$nombreFinal = time().$imagen_nombre;
		$directorio_final = "documentos/".$nombreFinal; 
        $sql = "INSERT INTO `rc_documentos`(`documento`, `rc`,`nombredoc`)  VALUES ('$nombreFinal', '$id', '$nombre')";
        $ejecucion = mysqli_query($con,$sql);
        
        //var_dump($ejecucion);
		
			if(move_uploaded_file($_FILES['imagenPropia']['tmp_name'], $directorio_final) && $ejecucion == true){

				$data = array(
					'status' => 'success',
					'code' => 200,
					'msj' => $nombreFinal
				);
				$format = (object) $data;
				$json = json_encode($format); 
				echo $json; 

			}else{

				$data = array(
					'status' => 'error',
					'code' => 400,
					'msj' => 'Error al mover imagen al servidor'
				);
				$format = (object) $data;
				$json = json_encode($format); 
				echo $json; 
			}


	}else{

		$data = array(
			'status' => 'error',
			'code' => 400,
			'msj' => 'No se recibio ninguna imagen'
		);
		$format = (object) $data;
		$json = json_encode($format); 
		echo $json; 

	}

?>