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



 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <a href="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/Listado/index.php?op=Listado" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
    <div class="row">
        <div class="col">
            <h1>Detalle Factura</h1>
<form>
    <?php $count = 0; foreach($detalle as $user){ ;  ?>
    <div class="row">
        <div class="col">
            <div>
            <p><strong>Tipo Factura:</strong> <?php echo $user['tipoFactura']; ?></p>
              </div>
              <div >
                <p><strong>ID Factura:</strong> <?php echo $user['id_transferencia']; ?></p>
              </div>
                <div >
                 <p><strong>Radicado:</strong> <?php echo $user['radicado']; ?></p>
              </div>
            <div>
            <p><strong>Numero Factura:</strong> <?php echo $user['factura']; ?></p>
            </div>
            <div>
                <p><strong>Fecha Factura:</strong> <?php echo $user['fecfact']; ?></p>
            </div>
            <div>
            <p><strong>NIT:</strong> <?php echo $user['nit']; ?></p>
              </div>
            <div>
        <p><strong>Establecimiento:</strong> <?php echo $user['establecimiento']; ?></p>   
        </div>
            <div>
            <p><strong>Tipo Gasto:</strong> <?php echo $user['tipogasto']; ?></p>
              </div>
               
              
            </div>
        <div class="col">
                
        </div>
    </div>
            
            <div class="form-group">
                <h2>Base</h2>
                <p><?=$user['moneda']?> $<?=number_format($user['valorSinImpuesto'],2); ?></p>
              </div>

              <div class="form-group">
                <h2>IVA</h2>
                <p><?=$user['moneda']?> $<?=number_format($user['valorImpuesto'],2); ?></p>
              </div>
              
              
              <div class="form-group">
                <h2>ICA</h2>
                <p><?=$user['moneda']?> $<?=number_format($user['valorIca'],2); ?></p>
              </div>

              <?php } ?>
</form>
        </div>
        
        <div class="col">
        <iframe src="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/uploads/<?php echo $user['fichero']?>"></iframe> 
        </div>
        
    </div>
    
    <?php if($user['estado'] == 'NO ACEPTO' || $user['estado'] == 2){?>
    
<button data-toggle="modal" data-target="#edicion" class="btn btn-lg" style ="  background-color: #00965e; color: white;"><i class="glyphicon glyphicon-pencil" style ="font-size: 15px;"></i></button>    <br> <br>
<textarea class="form-control" id="motivo" name="motivo"  disabled><?php echo $user['observacionG']; ?></textarea>
				<?php
										} 
										else{
										    
										}
										?>
										
	   <?php if($user['estado'] == 'NO ACEPTO'){?>

    <label>Motivo Rechazo</label>
        <textarea class="form-control" id="motivo" name="motivo"  disabled><?php echo $user['observacionG']; ?></textarea>
         		<?php
										} 
										else{
										    
										}
										?>   	
      <?php
$usuario = $user['id_transferencia'];
?>
<br>

<a href='#' class='btn btn-sm tablaGestion' data-toggle='modal' data-id='<?=$usuario;?>' data-target='#largeModal1' style='background-color:#00AB84; justify-content:center;' ><i class='glyphicon glyphicon-search icono' style='color:white;'></i></a><br><br>

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
                                                    <th scope="col">Fecha</th>
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
								
										
    
    <div class="modal fade" id="edicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edicion Factura</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body" style="padding: 30px;">
        <div class="row">
            <div class="col">
                <form action ="actualizaFactura.php" method="POST" enctype="multipart/form-data">
                    <label>Radicado</label>
                    <input type="text" name="radicado" class="form-control" value ="<? echo $user['radicado']; ?>">
                    <input type="hidden" name="transf" value ="<?php echo $user['id_transferencia']; ?>"></input>
                    <input type="hidden" name="userSess" value ="<?php echo $_SESSION['user_id']; ?>">
                <label>Fecha</label>
                <input type="text"  class="form-control inputstl" name="fecha" id="s" placeholder="Seleccionar Fecha" value="<?php echo $user['fecfact']; ?>">
                <label>Establecimiento</label>
                <input type="text" id="nombreM" name="nombre" class="form-control" value="<? echo $user['establecimiento']; ?>"></input>
                <label>Tipo Factura</label>
                <select id="gastoM" class="form-control form-control-lg" name="tipoGasto" >
                                <option value="<?= $user['tipoFactura'];?>"><?= $user['tipoFactura'];?></option>
                                <option value="ClienteF">Factura cliente Fisica</option>
                                <option value="ClienteE">Factura cliente Electronica</option>
                                <option value="Electronica">Factura electronica</option>
                                <option value="Fisica">Factura fisica</option>
                                <option value="Cobro">Cuenta de cobro</option>
                                <option value="Importacion">Factura de importacion</option>
			    			     </select>
                <label>IVA</label>
                <input id="ivaM" type="text" name="iva" class="form-control" value="<?= $user['valorImpuesto'];?>"></input>
            </div>
            <div class="col">
                <label>Factura</label>
                <input id="facturaM" type="text" name="factura" class="form-control" value="<?= $user['factura'];?>"></input>
                <label>NIT</label>
                <input id="nitM" type="text" class="form-control" name="nit" value="<?= $user['nit'];?>"></input>
                
                <label>Moneda</label>
                <select name="moneda" class="form-control input-sm"  id="Moneda1" style="height:25px;">
                <option value="<?= $user['moneda'];?>"><?= $user['moneda'];?></option>
                <option value="COP">Peso Colombiano</option>
                <option value="US">Dolares</option>
                <option value="EUR">Euros</option> 
                </select> 
                
                
                <label>Base</label>
                <input id="baseM" type="text" name="base" class="form-control" value="<?= $user['valorSinImpuesto'];?>"></input>
                <label>IPOCONSUMO</label>
                <input id="consumoM" type="text" name="consumo" class="form-control" value="<?= $user['valorIca'];?>"></input>
            </div>
            <input name="archivo" id="archivoM" type="file" class="form-control-file" value="<?= $user['fichero'];?>"></input><br>
            
            <label>Descripcion</label>
            <textarea class="form-control" name ="descripcion"><?= $user['descripcion'];?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
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

