<?php require_once('../Connections/scandinavia.php'); ?>
<?php


require_once("../seguridad/config.php");
$status = FALSE;

require_once("../seguridad/arraypermiso.php");

if ( authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["view"]) || 
authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["delete"]) ) {
 $status = TRUE;
}

       
if ($status === FALSE) {
die("You dont have the permission to access this page");
}

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Parametros = 20;
$pageNum_Parametros = 0;
if (isset($_GET['pageNum_Parametros'])) {
  $pageNum_Parametros = $_GET['pageNum_Parametros'];
}
$startRow_Parametros = $pageNum_Parametros * $maxRows_Parametros;

mysql_select_db($database_systempack, $systempack);
$query_Parametros = "SELECT a.id, a.idparametro, b.nombreparametro, a.descripcion, a.valor, a.idunidad, c.nombreunidad, c.nomenclatura, a.observacion FROM parametro_vs_valores a inner join parametros b on a.idparametro = b.id inner join unidadesmedida c on a.idunidad = c.id WHERE a.activo = 1 and b.estado = 1 and c.estado = 1 ORDER BY a.idparametro";
$query_limit_Parametros = sprintf("%s LIMIT %d, %d", $query_Parametros, $startRow_Parametros, $maxRows_Parametros);
$Parametros = mysql_query($query_limit_Parametros, $systempack) or die(mysql_error());
$row_Parametros = mysql_fetch_assoc($Parametros);

if (isset($_GET['totalRows_Parametros'])) {
  $totalRows_Parametros = $_GET['totalRows_Parametros'];
} else {
  $all_Parametros = mysql_query($query_Parametros);
  $totalRows_Parametros = mysql_num_rows($all_Parametros);
}
$totalPages_Parametros = ceil($totalRows_Parametros/$maxRows_Parametros)-1;

$queryString_Parametros = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Parametros") == false && 
        stristr($param, "totalRows_Parametros") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Parametros = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Parametros = sprintf("&totalRows_Parametros=%d%s", $totalRows_Parametros, $queryString_Parametros);
?>
<?php require_once('../cabeza.php'); ?>

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Administrar Valores por Parametros</h3>
          	
			 <form name="form1" method="post" action="">
               <div class="row mt">
          		<div class="col-lg-12">
          		<p><a href="nuevovalores.php">Nuevo</a>   </p>
          		<section id="unseen">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th><i class="fa fa-bookmark"></i> Parametro</th>
                        <th><i class="fa fa-bookmark"></i> Descripcion</th>
                        <th><i class="fa fa-bookmark"></i> Valor</th>
                        <th><i class="fa fa-bookmark"></i> Unidad</th>
                        <th><i class="fa fa-bookmark"></i> Observacion</th>
                        <th class="numeric">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php do { ?>
                      <tr>                      
                        <td><?php echo $row_Parametros['nombreparametro']; ?></td>
                        <td><?php echo $row_Parametros['descripcion']; ?></td>
                        <td><?php echo $row_Parametros['valor']; ?></td>
                        <td><?php echo $row_Parametros['nombreunidad']; ?></td>
                        <td><?php echo $row_Parametros['observacion']; ?></td>
                        <td ><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></td>
                         
                      </tr>
                       <?php } while ($row_Parametros = mysql_fetch_assoc($Parametros)); ?>
                    </tbody>
                  </table>
                </section>
               
                <p>
                  <?php if ($pageNum_Parametros > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_Parametros=%d%s", $currentPage, max(0, $pageNum_Parametros - 1), $queryString_Parametros); ?>">Anterior</a>
  <?php echo " -|- ";} // Show if not first page ?> 
                  <?php if ($pageNum_Parametros < $totalPages_Parametros) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Parametros=%d%s", $currentPage, min($totalPages_Parametros, $pageNum_Parametros + 1), $queryString_Parametros); ?>">Siguiente</a>
                    <?php } // Show if not last page ?>
                </p>
          		</div>
          	</div>
                </form>
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2018 - HBT
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

<?php require_once('../pie.php'); ?>
<?php
mysql_free_result($Parametros);
?>
