<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];


$sql = "DELETE FROM `archivos_facturas` WHERE `id_archivo`=". $id;
$resultado = mysqli_query($mysqli, $sql);

if($resultado == TRUE)
{
    echo "true";

}

else
{
    echo mysqli_error($mysqli);
   
}

?>