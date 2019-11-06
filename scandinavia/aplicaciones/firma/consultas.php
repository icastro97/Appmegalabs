<?php
//Firma

    
    
     function cargarImagen($cedula,$imagen)
    {
        
        $data = 'data:image/png;base64,iVBORw0K';
        list($type, $imagen) = explode(';', $imagen);
        list(,$extension) = explode('/',$type);
        list(,$imagen)      = explode(',', $imagen);
        $carpeta = 'upload/'.uniqid().'.'.$extension;
        $imagen = base64_decode($imagen);
        file_put_contents($carpeta, $imagen);
        
        
            global $bd;
            $sql = "INSERT INTO ubicacionFirma(cedula, ubicacion_imagen) VALUES ('$cedula','$carpeta')";
            $ejecutar = mysqli_query($bd,$sql);
            return $ejecutar;
        
                                     

    }
    
    
 
    
    function insertarDatosConsulta($codigos, $nombrem, $opcion, $cedula, $tratamiento, $publicidad, $material, $transferencia )
    {
        
            global $bd;
           
            $sql = "INSERT INTO `cruce`(`codigo`, `nombrem`, `opcion`, `cedula`, `tratamientoDatos`, `publicidad`, `materialCientifico`, `transferenciaValor`) VALUES ('$codigos', '$nombrem', '$opcion', '$cedula', '$tratamiento','$publicidad', '$material', '$transferencia')";
            $ejecutar = mysqli_query($bd,$sql);
            
    }
   

?>