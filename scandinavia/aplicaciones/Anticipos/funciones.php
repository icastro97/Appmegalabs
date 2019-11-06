<?php


function insertarDatos($consecutivo, $imagen)
    {
            
            
            global $bd;
            $sql = "UPDATE anticipo SET imagen='$imagen' where  consecutivo = ".$consecutivo;
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
            $sql = "UPDATE system_users SET ubicacionFirma='$carpeta' where  cedula = ".$cedula;
            $ejecutar = mysqli_query($bd,$sql);
            return $ejecutar;
        
                                       
    }


?>