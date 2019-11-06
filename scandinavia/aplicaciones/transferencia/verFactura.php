<?php 
    require_once "estilos.php";
    require_once("../../seguridad/config.php");
    $parametro = $_REQUEST['id'];
    $cedulaSesion = $_SESSION['identificacion'];

    $status = FALSE;


    require_once("../../seguridad/arraypermiso.php");
    unset($_SESSION['uId']);

    //start session
    //session_start();

    //get session data
    $sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

    $modulo = 'Legalizaciones';


    if (isset($_REQUEST['documento'])) {
        $sid = $_REQUEST['documento'];  		
    }


    //load and initialize database class
    require_once '../../mcv5/clases/DB.class.php';
    $db = new DB();

    //get users from database
    $conditionsempresa['where'] = array('id '=> 1,); 
    $empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


    $bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar


    $condition['where'] = array('cedulaSesion'=> $cedulaSesion,); 
    $usuario = $db->getRows('matrizaprobacion',$condition);

    $condition['where'] = array('id_transferencia'=> $sid,); 
    $detalle = $db->getRows('transferencia_val',$condition);

    
    $conditions1['where'] = array('u_userid'=> $detalle[0]['aprobador'],); 
    $apr = $db->getRows('system_users',$conditions1);


    //get status message from session
    if(!empty($sessData['status']['msg'])){
        $statusMsg = $sessData['status']['msg'];
        $statusMsgType = $sessData['status']['type'];
        unset($_SESSION['sessData']['status']);
    }
    ?>


    <?php  require_once('../../cabeza.php'); 

require_once('estilos.php');
    if(!isset($_SESSION["session_username"])) {	
    header("location:../../prueba.php");
    } 
    else {?>
        <!-- Main content -->
        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />	
<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>
<script src="main.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="estilostranfer.css">

<style>
p
{
    color:gray;
}
s
{
    background-color:red;
}
    
    
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <a href="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/Listado/index.php?op=Listado" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         
    <div class="row">
        <div class="col">
            
<form>
    
    <?php $count = 0; foreach($detalle as $user){ ;  ?>
    
    <div class="row">
        
        <div class="col-md-3"></div>
        <div class="col">
            <div>
            <h3>Detalle Factura</h3>    
            <p>Tipo Factura: <?php echo $user['tipoFactura']; ?></p>
              </div>
              <div >
                <p>ID Factura: <?php echo $user['id_transferencia']; ?></p>
              </div>
                <div >
                 <p>Radicado: <?php echo $user['radicado']; ?></p>
              </div>
            <div>
            <p>Numero Factura: <?php echo $user['factura']; ?></p>
            </div>
            <div>
                <p>Fecha Factura: <?php echo $user['fecfact']; ?></p>
            </div>
            <div>
            <p>NIT: <?php echo $user['nit']; ?></p>
              </div>
            <div>
        <p>Establecimiento: <?php echo $user['establecimiento']; ?></p>   
        </div>
            <div>
            <p>Tipo Gasto: <?php echo $user['tipogasto']; ?></p>
              </div>
               
              
            </div>
        <div class="col">
            <br>
            
            <h4>BASE</h4>
            <div class="form-group">
                
                <p><?=$user['moneda']?> $<?=number_format($user['valorSinImpuesto'],2); ?></p>
              </div>
              
             <br>
             
            <h4>IVA</h4>
              <div class="form-group">
                
                <p><?=$user['moneda']?> $<?=number_format($user['valorImpuesto'],2); ?></p>
              </div>
              <br>
             <h4>ICA</h4> 
              <div class="form-group">
                
                <p><?=$user['moneda']?> $<?=number_format($user['valorIca'],2); ?></p>
              </div>
     
        </div>
    </div>
           
              <?php } ?>
</form>
        </div>
        
        
     
    </div>
   <div class="col">
            <?php
            $usuario = $user['id_transferencia'];
            ?>
            <iframe src="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/uploads/<?php echo $user['fichero']?>" ></iframe> 
            <a href='#' class='btn btn-sm tablaGestion' data-toggle='modal' data-id='<?=$usuario;?>' data-target='#largeModal1' style='background-color:#00AB84; justify-content:center; margin-left:400px; margin-top:20px;' ><i class='glyphicon glyphicon-time icono' style='color:white;'> </i></a> <p style="color:black;margin-top:-20px; margin-left:450px;">Ver historial</p><br><br>
            <a href='mostrarAsistentes2.php?documento=<?=$usuario;?>' class='btn btn-sm' style='background-color:#00AB84; margin-left:600px; margin-top:-72px;' target='_blank'><i class='glyphicon glyphicon-paperclip icono' style='color:white;'></i></a> <p style="color:black;margin-top:-72px; margin-left:650px;">Ver documentos</p>
            
        </div>

<div class="modal fade bd-example-modal-lg" " id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="largeModal1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Historial Factura</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1 ">

													<div class="row">
															<div class="col-md-4"><input type="hidden" id="ide" value="<?=$usuario;?>"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table">
                                                  <thead class="thead-dark">
                                                    <tr>
                                                      <th scope="col">Fecha Cambio</th>    
                                                      <th scope="col">Responsable</th>
                                                      <th scope="col">Estado</th>
                                                      <th scope="col">Observacion</th>
                                                      
                                                    </tr>
                                                  </thead>
                                                  <tbody id="columna">
                                                    
                                                  </tbody>
                                                </table>

												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>
</div>
              

   
    
    
                </section>
                <p>&nbsp;</p>

      </section><! --/wrapper --><!-- /MAIN CONTENT -->

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


<?php require_once('../../pie.php'); }?>

