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
$query_ConfEmpresa = "SELECT * FROM empresa ORDER BY empresa.razonsocial";
$ConfEmpresa = mysql_query($query_ConfEmpresa, $systempack) or die(mysql_error());
$row_ConfEmpresa = mysql_fetch_assoc($ConfEmpresa);
$totalRows_ConfEmpresa = mysql_num_rows($ConfEmpresa);
?>
<?php require_once('../cabeza.php'); ?>

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <a href="http://appscandinavia.com/scandinavia/default1.php?group=Parametros" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Administrar Empresa</h3>
          	  <div class="col-12">
      <div class="table-responsive">
        <div class="panel panel-default users-content"> 
          		<section id="unseen">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th><i class="fa fa-bookmark"></i> NIT</th>
                        <th><i class="fa fa-bookmark"></i> Razon Social</th>
                        <th class="numeric"><i class="fa fa-bookmark"></i> Direccion</th>
                        <th class="numeric"><i class="fa fa-bookmark"></i> Telefono</th>
                        <th class="numeric"><i class="fa fa-bookmark"></i> Ciudad</th>
                        <th class="numeric"><i class="fa fa-bookmark"></i> Pais</th>
                        <th class="numeric">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $row_ConfEmpresa['nit']; ?></td>
                        <td><?php echo $row_ConfEmpresa['razonsocial']; ?></td>
                        <td><?php echo $row_ConfEmpresa['direccion']; ?></td>
                        <td><?php echo $row_ConfEmpresa['telefono']; ?></td>
                        <td ><?php echo $row_ConfEmpresa['ciudad']; ?></td>
                        <td ><?php echo $row_ConfEmpresa['pais']; ?></td>
                        <td ><?php if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["edit"])) { ?>	
                                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                      <?php  } ?>
                                   </td>
                      </tr>
                    </tbody>
                  </table>
               </div>
            </div>
    </div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

     
  </section>

<?php require_once('../pie.php'); ?>
		
<?php
mysql_free_result($ConfEmpresa);
?>
