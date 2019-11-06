<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];


$sql = "DELETE FROM `codigosinversion` WHERE `id`=". $id;
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