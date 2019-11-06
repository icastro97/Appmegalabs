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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO parametro_vs_valores (idparametro, descripcion, valor, idunidad, observacion) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombreparametro'], "int"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['unidad'], "int"),
                       GetSQLValueString($_POST['observacion'], "text"));

  mysql_select_db($database_systempack, $systempack);
  $Result1 = mysql_query($insertSQL, $systempack) or die(mysql_error());
}

mysql_select_db($database_systempack, $systempack);
$query_parametro = "SELECT parametros.id, parametros.nombreparametro FROM parametros WHERE parametros.estado=1";
$parametro = mysql_query($query_parametro, $systempack) or die(mysql_error());
$row_parametro = mysql_fetch_assoc($parametro);
$totalRows_parametro = mysql_num_rows($parametro);

mysql_select_db($database_systempack, $systempack);
$query_unidades = "SELECT unidadesmedida.id, unidadesmedida.nombreunidad FROM unidadesmedida WHERE unidadesmedida.estado = 1";
$unidades = mysql_query($query_unidades, $systempack) or die(mysql_error());
$row_unidades = mysql_fetch_assoc($unidades);
$totalRows_unidades = mysql_num_rows($unidades);
?>
<?php require_once('../cabeza.php'); ?>
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Administrar Valores por Parametros</h3>
          	
			 <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
               <div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th width="21%">Nombre de Parametro</th>
                        <th width="34%"><label for="nombreparametro"></label>
                          <select name="nombreparametro" id="nombreparametro">
                            <?php
do {  
?>
                            <option value="<?php echo $row_parametro['id']?>"><?php echo $row_parametro['nombreparametro']?></option>
                            <?php
} while ($row_parametro = mysql_fetch_assoc($parametro));
  $rows = mysql_num_rows($parametro);
  if($rows > 0) {
      mysql_data_seek($parametro, 0);
	  $row_parametro = mysql_fetch_assoc($parametro);
  }
?>
                        </select></th>
                        <th width="26%">Unidad</th>
                        <th width="19%"><select name="unidad" id="unidad">
                          <?php
do {  
?>
                          <option value="<?php echo $row_unidades['id']?>"><?php echo $row_unidades['nombreunidad']?></option>
                          <?php
} while ($row_unidades = mysql_fetch_assoc($unidades));
  $rows = mysql_num_rows($unidades);
  if($rows > 0) {
      mysql_data_seek($unidades, 0);
	  $row_unidades = mysql_fetch_assoc($unidades);
  }
?>
                        </select></th>
                      </tr>
                      <tr>
                        <th height="35">Descripcion</th>
                        <th valign="middle"><label for="observacion"></label>
                          <label for="descripcion"></label>
                        <input type="text" name="descripcion" id="descripcion"></th>
                        <th>Valor Parametro</th>
                        <th valign="middle"><label for="observacion">
                          <input type="text" name="valor" id="valor">
                        </label></th>
                      </tr>
                      <tr>
                        <th valign="middle">Observacion</th>
                        <th><textarea name="observacion" cols="70" rows="8" id="observacion"></textarea></th>
                        <th colspan="2"><input type="submit" name="button" id="button" value="Enviar"></th>
                      </tr>
                    </thead>
                    <tbody>
</tbody>
                  </table>
                </section>
               
                <p>&nbsp;</p>
          		</div>
          	</div>
               <input type="hidden" name="MM_insert" value="form1">
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
mysql_free_result($parametro);

mysql_free_result($unidades);
?>
