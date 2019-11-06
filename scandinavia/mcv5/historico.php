



<?php
require_once('../cabeza.php'); 
require_once("../Connections/scandinavia.php");
require_once("../seguridad/config.php");


mysql_select_db($database_systempack, $systempack);
$query_fechas = "select  count(fechaconvertida) as primerasemana, id from vw_cabezahome where  date(fechaconvertida) >=  date(primerdia) and date(fechaconvertida) <= date(primerasemana) union select  count(fechaconvertida) as segunda_semana, id from vw_cabezahome where  date(fechaconvertida) >=  date(primerasemana) and date(fechaconvertida) <= date(segundasemana) union select  count(fechaconvertida) as tercera_semana, id from vw_cabezahome where  date(fechaconvertida) >=  date(segundasemana) and date(fechaconvertida) <= date(tercerasemana) union select  count(fechaconvertida) as cuarta_semana, id from vw_cabezahome where  date(fechaconvertida) >=  date(tercerasemana) and date(fechaconvertida) <= date(cuartasemana)";
$fechas = mysql_query($query_fechas, $systempack) or die(mysql_error());
$row_fechas = mysql_fetch_assoc($fechas);
$totalRows_fechas = mysql_num_rows($fechas);


//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

//load and initialize database class
require_once 'clases/DB.class.php';
$db = new DB();

//get users from database
 $conditionscotizacionusers['where'] = array('cliente'=> $_REQUEST['id'],);
 $conditionscotizacionusers['limit'] = '30';
 $conditionscotizacionusers['order_by'] = 'fecha DESC';
 $cotizacionusers = $db->getRows('vw_cabezacotizacioncrm',$conditionscotizacionusers); //ojo se pone tabla a consultar


 $conditionsllamadas['where'] = array('idcliente'=> $_REQUEST['id'],);
 $conditionsllamadas['limit'] = '30';
 $conditionsllamadas['order_by'] = 'created DESC';
 $callusers = $db->getRows('llamadas',$conditionsllamadas); //ojo se pone tabla a consultar
 
 
  $conditionsvisitas['where'] = array('idcliente'=> $_REQUEST['id'],);
 $conditionsvisitas['limit'] = '30';
 $conditionsvisitas['order_by'] = 'created DESC';
 $visitausers = $db->getRows('seguimientos',$conditionsvisitas); //ojo se pone tabla a consultar



//get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}


if(!isset($_SESSION["session_username"])) {	
  header("location:../logininicial.php");
  
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

<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="../varios/validator.js"></script>
<style type="text/css">
.container{padding: 10px;}
.glyphicon{font-size: 20px;}
.glyphicon-arrow-left{float: right;}
a.glyphicon{text-decoration: none;}
</style>



 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-dashboard"></i>.:: DashBoard Cliente ::. </h3> 
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
                
          		<section id="unseen">
                
<?php require_once('iniciobusqueda.php'); ?>

                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<?php } ?>
    <div class="row">
		<div class="col-sm-6">
                <div class="panel-heading"><i class="fa fa fa-check-square-o"></i>&nbsp;Cotizaciones <a href="/cotizador/procesos/cotizacion.php?id=<?php echo $_REQUEST['id'];?>&op=COTIZADOR" class="glyphicon glyphicon-plus" ></a></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Cliente</th>
                            <th>Unidades</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody id="userData">
                        <?php if(!empty($cotizacionusers)): $count = 0; foreach($cotizacionusers as $usercoti): $count++; ?>
                        <tr>
                            <td><?php echo '#'.$count; ?></td>
                            <td><?php echo $usercoti['fecha']; ?></td>
                            <td><?php echo $usercoti['proyecto']; ?></td>
                            <td><?php echo $usercoti['ClienteNombre']; ?></td>
                            <td><?php echo $usercoti['unidades']; ?></td>
                            <td><?php echo $usercoti['descripcion']; ?></td>
                            <td><a href="/cotizador/procesos/vistacotizacion.php?cotizacion=<?php echo $usercoti['id']; ?>" title "Ver Cotización" class="glyphicon glyphicon-edit"></a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5">No hay Cotizaciones ......</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
<div class="col-sm-6">    
                <div class="panel-heading"><i class="fa fa-phone"></i>&nbsp;Llamadas   <a href="/cotizador/mcv5/view/addEditllamadascrm.php?filtro=1&op=LLAMADAS&cliente=<?php echo $_REQUEST['id'];?>" class="glyphicon glyphicon-plus" ></a></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tema</th>
                            <th>Contacto</th>
                            <th>Fecha</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody id="userData">
                        <?php if(!empty($callusers)): $count = 0; foreach($callusers as $userll): $count++; ?>
                        <tr>
                            <td><?php echo '#'.$count;?></td>
                            <td><?php echo $userll['subject'];?></td>
                            <td><?php echo $userll['contacto'];?></td>
                            <td><?php echo $userll['created'];?></td>                            
                           <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="<?php echo $userll['comment']; ?>">Ver</a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5">No hay Llamadas Realizadas ......</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>    
            
            
<div class="col-sm-6">
    
                <div class="panel-heading"><i class="fa fa-thumbs-o-up"></i>&nbsp;Visitas   <a href="/cotizador/mcv5/view/addEditvisitascrm.php?op=VISITAS&cliente=<?php echo $_REQUEST['id'];?>" class="glyphicon glyphicon-plus" ></a></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Fecha Visita</th>
                            <th>Motivo</th>
                            <th>Contacto</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody id="userData">
                        <?php if(!empty($visitausers)): $count = 0; foreach($visitausers as $uservisita): $count++; ?>
                        <tr>
                            <td><?php echo '#'.$count; ?></td>
                            <td><?php echo $uservisita['fechavisita']; ?></td>
                            <td><?php echo $uservisita['subject']; ?></td>
                            <td><?php echo $uservisita['contacto']; ?></td>
                            <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="<?php echo $uservisita['comment']; ?>">Ver</a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5">No hay Visitas con este cliente ......</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>         
            
            <br />
<br />
 <br />
<br />

					<div class="row">						
						<div class="col-sm-6">
							<!-- REVENUE PANEL -->
                            <?php
								$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
								?>
							<div class="darkblue-panel pn">
								<div class="darkblue-header">
									<h5>Estadisticas Cotizaciones de <?php echo  $meses[date('n')-1];?> </h5>
								</div>
								<div class="chart mt">
                                <?php $totales = 0; $valoresgrafo = "["; do {  $valoresgrafo = $valoresgrafo . "," . $row_fechas['primerasemana'] ;     $totales = $totales + $row_fechas['primerasemana']; ?>  <?php } while ($row_fechas = mysql_fetch_assoc($fechas));  $valoresgrafo = str_replace("[,","[",$valoresgrafo);  $valoresgrafo = $valoresgrafo. "]";?>
									<div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data='<?=$valoresgrafo ?>'></div>
								</div>
                                
								<p class="mt"><b></b><br/><?=$totales?> Cotizaciones a <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;?> </p>
							</div>
						</div><!-- /col-md-4 -->
					</div><!-- /row -->            
        </div>                                
                </section>

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

<?php require_once('../pie.php'); }?>
