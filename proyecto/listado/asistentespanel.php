<?php

require_once '../scandinavia/mcv5/clases/DB.class.php';


	 $consulta="SELECT u_username FROM system_users";
	 $sql = mysqli_query($mysqli, $consulta);
    
   $array = array();
    while($row = mysqli_fetch_array($sql))
    {
       $equipo = utf8_encode($row['u_username']);
       array_push($array, $equipo);
    }

   $jsonstring = json_encode($array);
	echo $jsonstring;
?> 
