<?php
/*
 * @author Shahrukh Khan
 * @website http://www.thesoftwareguy.in
 * @facebbok https://www.facebook.com/Thesoftwareguy7
 * @twitter https://twitter.com/thesoftwareguy7
 * @googleplus https://plus.google.com/+thesoftwareguyIn
 */
require_once("../seguridad/config.php");
require_once("../sesion.php");

// set page title
$title = "Dashboard";
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
$grupo = "";
// if the rights are not set then add them in the current session
if (!isset($_SESSION["access"])) {

    try {

        $sql = "SELECT icon, mod_modulegroupcode, mod_modulegroupname FROM module "
                . " WHERE 1 GROUP BY `mod_modulegroupcode` "
                . " ORDER BY `mod_modulegrouporder` ASC, `mod_moduleorder` ASC  ";


        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $commonModules = $stmt->fetchAll();

        $sql = "SELECT icon, mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename FROM module "
                . " WHERE 1 "
                . " ORDER BY `mod_modulegrouporder` ASC, `mod_moduleorder` ASC  ";

        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $allModules = $stmt->fetchAll();

        $sql = "SELECT rr_modulecode, rr_create,  rr_edit, rr_delete, rr_view FROM role_rights "
                . " WHERE  rr_rolecode = :rc "
                . " ORDER BY `rr_modulecode` ASC  ";

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rc", $_SESSION["rolecode"]);
        
        
        $stmt->execute();
        $userRights = $stmt->fetchAll();

        $_SESSION["access"] = set_rights($allModules, $userRights, $commonModules);
		//echo "valor sesion " . $_SESSION["access"];

    } catch (Exception $ex) {

        echo $ex->getMessage();
    }
}
?>






<?php require_once('../Connections/scandinavia.php'); 
session_start();
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
define('_CONSTANTE3', '5092');  //valor de variable para seccion 3 de cotizacion
define('_CONSTANTE4', '0.000384');  //valor de variable para seccion 4 de cotizacion
define('_CONSTANTE5', '180');  //valor de variable para seccion 5 de cotizacion
define('_CONSTANTE6', '1000');  //valor de variable para seccion 5 de cotizacion


mysql_select_db($database_systempack, $systempack);
$query_Empresa = "SELECT razonsocial FROM empresa";
$Empresa = mysql_query($query_Empresa, $systempack) or die(mysql_error());
$row_Empresa = mysql_fetch_assoc($Empresa);
$totalRows_Empresa = mysql_num_rows($Empresa);
 $variablegrupo = "";
if (isset($_REQUEST["group"])) {
	 $variablegrupo = $_REQUEST["group"];
}
 
$usuario = $_SESSION["user_id"];

//$sql20="select * FROM module order by  mod_modulegroupname, mod_moduleorder  ";


$consulta = "SELECT respuesta, modulo FROM `matrizaprobacion` where modulo = 'Anticipos' and sesion =". $usuario;
$sql = mysqli_query($mysqli, $consulta);

while($row = mysqli_fetch_assoc($sql))
{
	 $estados = $row['respuesta'];
	 $modulo = $row['modulo'];
}

$consulta1 = "SELECT respuesta, modulo FROM `matrizaprobacion` where modulo = 'Legalizaciones' and sesion =". $usuario;
$sql1 = mysqli_query($mysqli, $consulta1);

while($row = mysqli_fetch_assoc($sql1))
{
	 $estados1 = $row['respuesta'];
	 $modulo1 = $row['modulo'];
}
    try {
         $sql = "SELECT  mod_modulegroupcode, mod_modulegroupname FROM module    GROUP BY  mod_modulegroupcode, mod_modulegroupname  ORDER BY  mod_modulegroupcode, mod_modulegroupname";

        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $commonModules = $stmt->fetchAll();

          $sql = "SELECT icon, mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename FROM module "
                . " WHERE 1 "
                . " ORDER BY `mod_modulegrouporder` ASC, `mod_moduleorder` ASC  ";
                
        
        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $allModules = $stmt->fetchAll();

        $sql = "SELECT rr_modulecode, rr_create,  rr_edit, rr_delete, rr_view FROM role_rights "
                . " WHERE  rr_rolecode = :rc "
                . " ORDER BY `rr_modulecode` ASC  ";

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rc", $_SESSION["rolecode"]);
        
        
        $stmt->execute();
        $userRights = $stmt->fetchAll();

        $_SESSION["access"] = set_rights($allModules, $userRights, $commonModules);
		//echo "valor sesion " . $_SESSION["access"];


    } catch (Exception $ex) {

        echo $ex->getMessage();
    }

?>




<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Aplicaciones :,SCANDINAVIA PHARMA</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="https://appmegalabs.com/scandinavia/cabeza/style.css">


</head>
<body>
<!-- partial:index.partial.html -->
<nav class="mnb navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <i class="ic fa fa-bars"></i>
      </button>
      <div style="padding: 15px 0;">
         <a href="#" id="msbo"><i class="ic fa fa-bars"></i></a>
      </div>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['session_name'];?><br><strong><?php echo $_SESSION["rolecode"];?></strong><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="https://appmegalabs.com/scandinavia/seguridad/logout.php">Salir</a></li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-bell-o"></i></a></li>
        <li><a href="#"><i class="fa fa-comment-o"></i></a></li>
      </ul>
    </div>
  </div>
</nav>
<!--msb: main sidebar-->
<div class="msb" id="msb">
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<div class="brand-wrapper">
					<!-- Brand -->
					<div class="brand-name-wrapper">
						<a class="navbar-brand" href="#">
							<img src="https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png" width="150px" height="60px">
						</a>
					</div>

				</div>

			</div>

			<!-- Main Menu -->
			<div class="side-menu-container">
				<ul class="nav navbar-nav">

					<li><a href="https://appmegalabs.com/scandinavia/default.php"><i class="fa fa-home"></i> Inicio</a></li>
					<!-- Dropdown-->
					
					<?php foreach ($_SESSION["access"] as $key => $access) { 
					    $grupo = $access["top_menu_name"];
					$i;  ?>
					
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#<?php echo $access["top_menu_name"]; ?>">
	                     <?php echo $access["top_menu_name"]; ?>
						  <span class="caret"></span>
                        </a>
                        
						<!-- Dropdown level 1 -->
						<div id="<?php echo $access["top_menu_name"]; ?>" class="panel-collapse collapse">
							<div class="panel-body">
								<ul class="nav navbar-nav">
								    <?php

                                    $sql20= "select a.id, a.mod_modulegroupcode,a.mod_modulegroupname, a.mod_modulecode, a.mod_modulename, a.mod_modulepagename,  a.icon,b.rr_rolecode, b.status, c.u_userid, c.full_name, c.u_rolecode FROM module a inner join role_rights b on a.mod_modulecode = b.rr_modulecode inner join system_users c on c.u_rolecode = b.rr_rolecode where c.u_userid = " . $_SESSION["user_id"] . " and mod_modulegroupname = 'Administracion' order by a.mod_modulegrouporder,  a.mod_moduleorder ";
                                   $Observacion = mysql_query($mysqli, $sql20);
                                    $row_Obser = mysql_fetch_assoc($Observacion);
                                    $rowcount=mysql_num_rows($Observacion);
                                       var_dump($rowcount);
                                 
                                    ?>
                                    
									<li><a href="#">dfsd</a></li>
									<?php  ?>
								</ul>
							</div>
						</div>
					</li>
					
					
					              <?php
					              $i++;
                    }
         
                    ?>
					
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>  
</div>
<!--main content wrapper-->
<div class="mcw">
</div>
  <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script  src="https://appmegalabs.com/scandinavia/cabeza/script.js"></script>