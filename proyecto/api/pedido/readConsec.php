<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE');

$prueba = $_GET['id'];

echo json_encode($prueba);

  ?>