<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
    // not logged in send to login page
	 header("Location: /scandinavia/seguridad/index.php");
	
}
$status = FALSE;
?>