<?php


function insertarDatos($cedula, $imagen)
    {
            
            global $bd;
            $sql = "INSERT INTO formulario_firma(cedula, imagen) VALUES ($cedula, '$imagen')";
            $ejecutar = mysqli_query($bd,$sql);
            return $ejecutar;
        
    }

function cargarImagen($cedula,$imagen)
    {
        
        $data = 'data:image/png;base64,iVBORw0K';
        list($type, $imagen) = explode(';', $imagen);
        list(,$extension) = explode('/',$type);
        list(,$imagen)      = explode(',', $imagen);
        $carpeta = 'uploads/'.uniqid().'.'.$extension;
        $imagen = base64_decode($imagen);
        file_put_contents($carpeta, $imagen);
        
        
            global $bd;
            $sql = "INSERT INTO ubicacionFirma(cedula, ubicacion_imagen) VALUES ('$cedula','$carpeta')";
            $ejecutar = mysqli_query($bd,$sql);
            return $ejecutar;
        
                                       
    }
?>