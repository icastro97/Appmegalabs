<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database
 $conditions['where'] = array('NIT'=> $parametro,);
 $conditions['order_by'] = ' tipo, DocOrig '; 
$users = $db->getRows('vw_basec_vendedores',$conditions); //ojo se pone tabla a consultar

//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>


<?php require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
} 
else {?>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Documentos por Cliente</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">

                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
    <div >
        <div class="panel panel-default users-content">
            <div class="panel-body">Documentos Actuales   </div>
            <form action="rc.php" method="get">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Procesar</th>
                        <th>Tipo</th>
                        <th>Documento</th>
                        <th>Fecha</th>
                        <th>Vencimiento</th>
                        <th>cod</th>
                        <th align="right"><div align="right">Valor</div></th>
                        <th align="right"><div align="right">Abono</div></th>
                        <th align="right"><div align="right">Saldo</div></th>
                        <th align="right"><div align="right">Saldo APP</div></th>
                        <th>Presupuestado</th>                       
                        
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php if(!empty($users)): $count = 0; foreach($users as $user): $count++; ?>
                    <tr>
                        <td><?php echo '#'.$count; ?></td>
                        <td>  <?php $valorcheck = $user['Documento']; ?>
                               <?php 
							      $valdocapp = $user['Impositiva'] + $user['PPago'] + $user['DAdicional'] + $user['OtrosDescuentos'] + $user['ValNota'];								
							   if ( $user['Saldo']  <=  ($user['ValNeto'] + $valdocapp + 1)  && $user['Tipo'] == 'FV'){ echo "/";} else{?>             
							 <input name="documento[]" type="checkbox" class="checkbox" id= "documento<?php echo $count; ?>" value="<?php echo $valorcheck; ?>">                             <?php } ?>
                             
                        </td>
                        <td><?php echo"<p align='center'> <font color=" . $user['Semaforo'] . "> " . $user['Tipo']. "</font> </p>"; ?></td>
                        <td><?php echo"<p align='center'> <font color=" . $user['Semaforo'] . "> " . $user['DocOrig']. "</font> </p>"; ?></td>
                        <td><?php echo"<p align='center'> <font color=" . $user['Semaforo'] . "> " . $user['OpeFecha']. "</font> </p>"; ?></td>
                        <td><?php echo"<p align='center'> <font color=" . $user['Semaforo'] . "> " . $user['VtoFecha'] . "</font> </p>";  ?></td>
                        <td><?php echo"<p align='center'> <font color=" . $user['Semaforo'] . "> " . $user['cod']. "</font> </p>"; ?></td>
                        <td align="right">$<?=number_format($user['Valor_original'], 0,".",",") ?></td>  
                        <td align="right">$<?=number_format($user['Abono'], 0,".",",") ?></td>  
                        <td align="right">$<?=number_format($user['Saldo'], 0,".",",") ?></td> 
                        <td align="right">$<?=number_format($user['ValNeto'], 0,".",",") ?></td>  
                        <td><?php $color = "#33cc33";
						if ($user['En_presupuesto'] == "Presupuestado"){ 
						     echo"<p align='center'> <font color=" .$color . "> " . $user['En_presupuesto']. "</font> </p>";
						}else{
							  $color = "#ff9900";
							  echo"<p align='center'> <font color=" .$color . "> " . $user['En_presupuesto']. "</font> </p>";
						}?>
                        </td>
                        
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="6">No existen documentos para mostrar......</td></tr>
                    <?php endif; ?>
                </tbody>
            </table><br>
<br>
<?php //if (authorize($_SESSION["access"][$moduloconsulto][$modulecodigo]["create"])) { ?>
            <div align="center">
            
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
              <input name="" type="submit" class="btn-primary" value="Enviar Información">
            </div><br>
<?php //}?>
            </form>           
        </div>
    </div>
</div>                  
                  
                  
                </section>
                <p>&nbsp;</p>
          		</div>
          	</div>
			

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

<?php require_once('../../pie.php'); }?>
