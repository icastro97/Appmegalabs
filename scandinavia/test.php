


<?php
/* capturar variable por método GET */
if (isset($_GET['pos']))
  $ini=$_GET['pos'];
else
  $ini=1; 
?>
<!DOCTYPE html>
<html>
 <head>
 <link rel="stylesheet" href="bootstrap.css" type="text/css">
 <title>Paginación de registro</title>
 <style>
   #tablephp {width:450px; font-size:12px; padding:50px;}
   table th{background-color:#AED7FF;}
 </style>
</head>
 <body>
  <center>
   <div id="tablephp">
    
    
<?php


/* constantes */
const HOST = 'localhost';
const USER = 'root';
const PASSWD = '';
const DB = 'appsystem';
const TABLE = 'x2_contacts';

/* variables */
$order="id desc";
$url = basename($_SERVER ["PHP_SELF"]);
$limit_end = 25;
$init = ($ini-1) * $limit_end;

/* querys */
$count="SELECT COUNT(*) FROM ".TABLE."";
$select = "SELECT *FROM ".TABLE." ORDER BY $order";
$select .= " LIMIT $init, $limit_end";

/* conexión al servidor de base de datos */
$mysql = new mysqli(HOST, USER, PASSWD, DB);

if ($mysql->connect_error) 
{
  die("Error al conectarse al servidor");
   
}else{
   
  $num = $mysql->query($count);
  $x = $num->fetch_array();
 
  $total = ceil($x[0]/$limit_end);

  echo "<table border='1' class='table table-bordered table-hover'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th><b>Nombre</b></th>";
  echo "<th><b>Apellido</b></th>";
  echo "<th><b>Cédula</b></th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
 
  $c = $mysql->query($select);
  while($rows = $c->fetch_array(MYSQLI_ASSOC))
  {
    echo "<tr>";
    echo "<td>".$rows['name']."</td>";
    echo "<td>".$rows['email']."</td>";
    echo "<td>".$rows['phone']."</td>";

    echo "</tr>";
  }
 
  echo "</tbody>";
  echo "<table>";
 
  /* numeración de registros [importante]*/
  echo "<div class='pagination'>";
  echo "<ul>";
  /****************************************/
  if(($ini - 1) == 0)
  {
    echo "<li><a href='#'>&laquo;</a></li>";
  }
  else
  {
    echo "<li><a href='$url?pos=".($ini-1)."'><b>&laquo;</b></a></li>";
  }
  /****************************************/
  for($k=1; $k <= $total; $k++)
  {
    if($ini == $k)
    {
      echo "<li><a href='#'><b>".$k."</b></a></li>";
    }
    else
    {
      echo "<li><a href='$url?pos=$k'>".$k."</a></li>";
    }
  }
  /****************************************/
  if($ini == $total)
  {
    echo "<li><a href='#'>&raquo;</a></li>";
  }
  else
  {
    echo "<li><a href='$url?pos=".($ini+1)."'><b>&raquo;</b></a></li>";
  }
  /*******************END*******************/
  echo "</ul>";
  echo "</div>";
}
?>
    
    
    
    
    
    
    
    
    
    
   </div>
  </center>
 </body>
</html>