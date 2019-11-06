<?php
/*
 * @author Shahrukh Khan
 * @website http://www.thesoftwareguy.in
 * @facebbok https://www.facebook.com/Thesoftwareguy7
 * @twitter https://twitter.com/thesoftwareguy7
 * @googleplus https://plus.google.com/+thesoftwareguyIn
 */
require_once("../../../seguridad/config.php");
require_once("../../../sesion.php");

// set page title
$title = "Dashboard";
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 

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






<?php require_once('../../scandinavia/Connections/scandinavia.php'); 
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
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" type="image/x-icon" href="icono.ico" />
    <title>Aplicaciones :. <?php echo $row_Empresa['razonsocial']; ?> .:</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    
    <link rel="stylesheet" type="text/css" href="/scandinavia/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/scandinavia/assets/css/quick.css">
    
    <script src="/scandinavia/bootstrap/js/jquery.min.js"></script>   
    
    <script src="/scandinavia/bootstrap/js/bootstrap.min.js"></script>
    
    
    <script src="/scandinavia/bootstrap/js/typeahead.js"></script>
    
     
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
   <!--
    <script src="/scandinavia/assets/js/require.min.js"></script>
    
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script>-->
    <!-- Dashboard Core -->
    <link href="/scandinavia/assets/css/dashboard.css" rel="stylesheet" />
    <script src="/scandinavia/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="/scandinavia/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="/scandinavia/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="/scandinavia/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="/scandinavia/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="/scandinavia/assets/plugins/input-mask/plugin.js"></script>
    
    
    


<style>
	.typeahead { border: 2px solid #fff;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;background:#00965e ;color: #FFF;}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;border-bottom:#00965e  1px solid;color:#00965e ;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.lista-color {max-width: 450px;min-width: 290px;max-height:340px;
	border-radius:4px;text-align:left;margin:10px; margin-bottom:120px;}
	.Busca-pais {font-size:1.5em;color: #00965e ;font-weight: 700; text-align:left}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #337ab7;
		outline: 0;
	}
  .form-control{width:300px;}
  .texto
  {
     margin-left:50px;
     color:#337ab7;
  }
	</style>
</head>

  <body>
<body >
    <div >
      <div >
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="/scandinavia/default.php">
                <img src="/scandinavia/assets/img/Megalabs_Logo.png" width="300" alt="<?php echo $row_Empresa['razonsocial']; ?>">                   
                  <div class="texto">
                    Scandinavia Pharma LTDA. 
                    <h6>Una compañia MegaLabs </h6>
                  </div>
                    
                     
              </a>
              <div class="d-flex order-lg-2 ml-auto">                
                 
                  <div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo $_SESSION['session_name'];?></span>
                      <small class="text-muted d-block mt-1"><?php echo $_SESSION["rolecode"];?></small>
                      
                    </span>
                  </a>                  
                  <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                    <a class="dropdown-item" href="/scandinavia/mcv5/view/perfil.php">
                      <i class="dropdown-icon fe fe-user"></i> Perfil
                    </a>
                  
                    <a class="dropdown-item" href="/scandinavia/seguridad/logout.php">
                      <i class="dropdown-icon fe fe-log-out"></i> Cerrar Sesion
                     
                    </a>
                  </div>
                </div>
              </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <!--<div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                            <div class="lista-color">
                    			<label class="Busca-pais">Busca tu Nombre:</label><br/> 
                   				 <input type="text" name="MiPais" id="MiPais"  class="form-control"/>
                			</div>
              
              
                <form class="input-icon my-3 my-lg-0">
                  <input type="search" class="form-control header-search" id="busqueda" placeholder="Buscar&hellip;" tabindex="1" onKeyUp="buscar();">
                  <div id="resultadoBusqueda"></div>
                 
                  <div id="resultadoBusqueda" style="position: absolute; display: block; width: 318px; top: 245.5px; left: 133.5px;"> </div>
                
                
                  
                  
                </form>
               
              </div>-->
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="/scandinavia/default.php" class="nav-link active" style="color:#00965e;"><i class="fe fe-home"></i> Inicio</a>
                    
                  </li>
                  <!--
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Opcion 1</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./cards.html" class="dropdown-item ">Cards design</a>
                      <a href="./charts.html" class="dropdown-item ">Charts</a>
                      <a href="./pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-calendar"></i> Opcion 2</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./maps.html" class="dropdown-item ">Maps</a>
                      <a href="./icons.html" class="dropdown-item ">Icons</a>
                      <a href="./store.html" class="dropdown-item ">Store</a>
                      <a href="./blog.html" class="dropdown-item ">Blog</a>
                      <a href="./carousel.html" class="dropdown-item ">Carousel</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> Opcion 3</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./profile.html" class="dropdown-item ">Profile</a>
                      <a href="./login.html" class="dropdown-item ">Login</a>
                      <a href="./register.html" class="dropdown-item ">Register</a>
                      <a href="./forgot-password.html" class="dropdown-item ">Forgot password</a>
                      <a href="./400.html" class="dropdown-item ">400 error</a>
                      <a href="./401.html" class="dropdown-item ">401 error</a>
                      <a href="./403.html" class="dropdown-item ">403 error</a>
                      <a href="./404.html" class="dropdown-item ">404 error</a>
                      <a href="./500.html" class="dropdown-item ">500 error</a>
                      <a href="./503.html" class="dropdown-item ">503 error</a>
                      <a href="./email.html" class="dropdown-item ">Email</a>
                      <a href="./empty.html" class="dropdown-item ">Empty page</a>
                      <a href="./rtl.html" class="dropdown-item ">RTL mode</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="./form-elements.html" class="nav-link"><i class="fe fe-check-square"></i> Opcion 4</a>
                  </li>
                  <li class="nav-item">
                    <a href="./gallery.html" class="nav-link"><i class="fe fe-image"></i> Opcion 5 </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/index.html" class="nav-link"><i class="fe fe-file-text"></i> Opcion 6</a>
                  </li>-->
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">

         
         
      
