<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_systempack = "localhost";
$database_systempack = "scandapp_app";
$username_systempack = "scandapp_app";
$password_systempack = "Qwerty1234$";
$systempack = @mysql_pconnect($hostname_systempack, $username_systempack, $password_systempack) or trigger_error(mysql_error(),E_USER_ERROR); 
?>