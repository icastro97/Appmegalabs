<?php

require_once '../../mcv5/clases/DB.class.php';

$id = $_POST['id'];
$codigo = $_POST['codigo'];
$porcentual = $_POST['porcentual'];


$sql = "INSERT INTO codigosinversion (id_factura, codigoInversion, porcentual) VALUES ('$id', '$codigo', '$porcentual')";
$query = mysqli_query($mysqli, $sql);
if ($query == TRUE) 
{
    echo "bien";
}
else
{
    echo mysqli_error($mysqli);
}

?>