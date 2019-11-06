<?php
require("database.php"); // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB
   // REALIZA LA QUERY A LA DB
   $sql ="DELETE FROM `matrizPrecios` WHERE id = '$_GET[id]'";
   $registros = mysqli_query($con,$sql);

  // SI EL USUARIO EXISTE OBTIENE LOS DATOS Y LOS GUARDA EN UN ARRAY

    class Result {}
        // GENERA LOS DATOS DE RESPUESTA
        $response = new Result();
        if ($registros == TRUE) {
            $response->resultado = 'OK';
            $response->mensaje = 'Registro eliminado';
        }
        else {
            $response->resultado = 'mal';
            $response->mensaje = mysqli_error($bd);
        }

        header('Content-Type: application/json');
        echo json_encode($response); // MUESTRA EL JSON GENERADO
?>