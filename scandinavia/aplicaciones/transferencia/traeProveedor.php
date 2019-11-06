<?php


require_once '../../mcv5/clases/DB.class.php';

$nit = $_POST['valor'];


$sql = "select razonsocial from proveedores where nit = '$nit'";


$ejecucion = mysqli_query($mysqli, $sql);

while($var = mysqli_fetch_assoc($ejecucion))
{
    $row = $var['razonsocial'];
}

if($ejecucion)
{
    
    echo $row;
}
else
{
    echo $row;
}




?>