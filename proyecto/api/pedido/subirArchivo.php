<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require 'database.php';
$consec = $_GET['consec'];
    if(isset($_FILES['imagenPropia'])){ 

        $imagen_tipo = $_FILES['imagenPropia']['type']; 
        $archivo_nombre = $_FILES['imagenPropia']['name']; 
        $nombreServer = time().$archivo_nombre;
        $directorio_final = "../../scandinavia/documentos/".$nombreServer; 
        $var= $_FILES['imagenPropia']['tmp_name'];

            if(move_uploaded_file($var, $directorio_final)){ 
            $sql = "UPDATE ped_cabeza SET nombreArchivo = '$nombreServer' WHERE id_c = '$consec'";
            $result = mysqli_query($con,$sql);
                $data = array( 
                    'status' => 'success', 
                    'code' => 200, 
                    'msj' => 'Imagen subida',
                    'fichero' => $directorio_final,
                    'documento'=> $nombreServer
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