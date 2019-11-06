<?php

$serverName = "scap030bog\procesos"; //serverName\instanceName
$connectionInfo = array( "Database"=>"scandapp_app", "UID"=>"sa", "PWD"=>"Abcd1234!!");
$conn = sqlsrv_connect( $serverName, $connectionInfo);


if($conn)
{
    echo "Conectado";
}
else
{
    echo "No conectado";
    die( print_r( sqlsrv_errors(), true));
}

?>