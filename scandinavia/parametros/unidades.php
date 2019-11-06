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

mysql_select_db($database_systempack, $systempack);
$query_Parametros = "SELECT * FROM unidadesmedida WHERE unidadesmedida.estado = 1 ";
$Parametros = mysql_query($query_Parametros, $systempack) or die(mysql_error());
$row_Parametros = mysql_fetch_assoc($Parametros);
$totalRows_Parametros = mysql_num_rows($Parametros);
?>
<?php require_once('../cabeza.php'); ?>

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Unidades de Medida</h3>
          	
			 <form name="form1" method="post" action="">
               <div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th><i class="fa fa-bookmark"></i> Consecutivo</th>
                        <th><i class="fa fa-bookmark"></i> Unidad</th>
                        <th><i class="fa fa-bookmark"></i> Nomenclatura</th>
                        <th class="numeric">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php do { ?>
                      <tr>                      
                        <td><?php echo $row_Parametros['id']; ?></td>
                        <td><?php echo $row_Parametros['nombreunidad']; ?></td>
                        <td><?php echo $row_Parametros['nomenclatura']; ?></td>
                        <td ><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></td>
                         
                      </tr>
                       <?php } while ($row_Parametros = mysql_fetch_assoc($Parametros)); ?>
                    </tbody>
                  </table>
                </section>
               
                <p>&nbsp;</p>
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
