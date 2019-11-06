<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE');


$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
 
$params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE


echo $params;

?>