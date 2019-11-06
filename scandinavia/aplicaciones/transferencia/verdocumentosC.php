<?php 
    require_once "estilos.php";
    require_once("../../seguridad/config.php");
    $parametro = $_REQUEST['id'];
	$cedulaSesion = $_SESSION['identificacion'];
	$user_id = $_SESSION['id'];


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

	$condicional['where'] = array('id_factura'=> $sid,); 
    $codigo = $db->getRows('codigos_transferencia',$condicional);
    
    $conditions1['where'] = array('u_userid'=> $detalle[0]['aprobador'],); 
	$apr = $db->getRows('system_users',$conditions1);
	
    $condicion['where'] = array('id_factura'=> $sid,); 
	$cond = $db->getRows('codigos_transferencia',$condicion);

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
    .botonimagen{
    	background-image:url("https://image.flaticon.com/icons/svg/721/721468.svg");
    	background-repeat:no-repeat;
    	height:100px;
    	width:100px;
    	background-position:center;
    	color:red;
	}
</style>

 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            <a href="javascript:history.back(-1);" title="Ir la página anterior" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
                 <br> 
                
			<td >&nbsp;</td><td >&nbsp;</td>
			<div class="table-responsive">  
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado1">
                 
                </div></td>
              </tr>
              
		<tr>
                <td><div id="resultadotemporal">

						 
								<table class="table table-striped table-bordered">
								
								<tbody id="userData">
									<tr></tr>
								</tbody>
								<thead>
									<tr>
										<th rowspan="2">No</th>									
										<th rowspan="2" valign="bottom"><div align="center">Fecha</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Factura</div></th>
										<th rowspan="2" align="center" ><div align="center">NIT</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Establecimiento </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Codigo de inversión </div></th>
										<th rowspan="2" valign="bottom"><div align="center">Tipo Gasto</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Base</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Iva</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Impo Consumo</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Adjunto</div></th>																				
										
									
										
									</tr>
									<tr></tr>
								</thead>
								<tbody id="userData2">
									<?php $sumaneto = 0;
									if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
									<tr>
									<td><?php echo $user['id_transferencia']; ?></td>
									
										<td align="center"><?php echo $user['fecfact']; ?></td>
										<td align="center">
											<?=($user['factura']) ?></td>
										<td align="center">
											<?=($user['nit']) ?></td>
											
										<td align="center">
											<?=$user['establecimiento']; ?></td>
										<td align="center">
											<?php if ($user['estado'] != "APR") {
										
											 ?>
										<a href="" class="btn btn-primary botonarr" data-toggle="modal" data-id="<?php echo $usuario?>" data-toggle="modal" data-target="#exampleModal"><i class="glyphicon glyphicon-plus"></i></a>
										<?php
											}
																				
										
										else{
											echo "";
										}
									
										$sql = "SELECT * FROM codigosinversion where id_factura = ".$user['id_transferencia'];
										$query = mysqli_query($mysqli, $sql);
										$numero = mysqli_num_rows($query);
										
										if($numero > 0)
										{
										?>
										<a href="" class="btn btn-primary botonarr" data-toggle="modal" data-id="<?php echo $usuario?>" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="traecodigos2(<?php echo $user['id_transferencia'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a>
										<input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#largeModal">
										<?php
										}
										else
										{
										    
										}
										?>

    </td>
										<td align="center">
											<?=$user['tipogasto']; ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorSinImpuesto'],2); ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorImpuesto'],2); ?></td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($user['valorIca'],2); ?></td>
										
										<td align="center">
											<?php 
											if($user['tipo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' />"; 
											}
											else if($user['tipo'] == "image/png")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' />"; 
												
											}  
											else if ($user['tipo'] == "application/pdf")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' />";                   
											}
											else if($user['tipo'] == "image/jpg" or $user['tipo'] == "image/jpeg")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' />"; 
											}	
											else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' />"; 
											}
											else if($user['tipo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
											{
												echo "<a href=\"uploads/" . $user['fichero'] . " \"target=\"\_blank\">";
												echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' />"; 
											}
											?>
										</td>
										
							
										
										
										
									</tr>
									
									
									<?php endforeach; else: ?>
									<tr>
										<td colspan="7">No existen documentos para mostrar......</td>
									</tr>
									<?php endif; ?>
									
									
                             
							  
							  
								</tbody>
								
								<tbody>

								</tbody>
								
									
									
								</table>
							

								</div> 

                </div>
								</td>
              </tr>
						
              

              
            </table>
            

            
		     
          </form> 
            
            

 
            
                      
		</div>
		
		<?php
if($user['estado'] == "APR")
{
    $novedad = $user['novedad'];
    if($novedad)
    {
        
    
	?>

   <div class="alert alert-danger" role="alert" >
<h4><?= $novedad?></h4>

  </div>
	<?php
    }
    else
    {
    ?>
    
    <div class="alert alert-success" role="alert" >
<h4>No hay ninguna novedad.</h4>

  </div>
    <?php    
    }
	?>

<?php
if($user['tipoApr'] == "REVC" || $user['tipoApr'] == "ENVC")
{
    
    
?>
 <div class="row">
                              <div class="col-md-3">
                                  
                              </div>
                              <div class="col-md-6">
                                  <textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"></textarea>
                              </div>
                                   
                                   		
                          </div>	
                          <br>
                          <div class="row">
                              <div class="col-md-1"></div>
                               <div class="col-md-2">
                                   <a href="#" onclick="enviarTesoreria(<?php echo $sid; ?> )" name="Aprobar" id="Aprobar"  class="btn"/>
                                   <img src="https://image.flaticon.com/icons/svg/204/204276.svg" width="50px" height="50px">
                                   </a>
                                   <br>
                                   Enviar Tesoreria
                               </div>
                               
                               <div class="col-md-2">
                                   <a href="#" onclick="enviarCartera(<?php echo $sid; ?>)" name="Aprobar" id="Aprobar"  class="btn" />
                                   <img src="https://image.flaticon.com/icons/svg/235/235269.svg" width="50px" height="50px">
                                   </a>
                                   <br>
                                   Enviar Cartera
                               </div>
                               <div class="col-md-2">
                                   <a href="#" onclick="cruzarContabilidad(<?php echo $sid; ?>)" name="Aprobar" id="Aprobar"  class="btn"  /> 
                                   <img src="https://image.flaticon.com/icons/svg/2037/2037012.svg" width="50px" height="50px">
                                   </a>
                                   <br>
                                   Cruce Contabilidad
                               </div>
                               <div class="col-md-2">
                                   <a href="#" onclick="pendienteNota(<?php echo $sid; ?>)" name="Aprobar" id="Aprobar"  class="btn" /> 
                                   <img src="https://image.flaticon.com/icons/svg/138/138296.svg" width="50px" height="50px">
                                   </a>
                                   <br>
                                   Pendiente Nota Credito
                               </div>
                               <div class="col-md-3">
                                   <a href="#" onclick="sinFinalizar(<?php echo $sid; ?>)" name="Aprobar" id="Aprobar"  class="btn"  /> 
                                   <img src="https://image.flaticon.com/icons/svg/1754/1754703.svg" width="50px" height="50px">
                                   </a>
                                   <br>
                                   Finalizar Sin Contabilizacion
                               </div>
                          </div>
<?php
}
else
{
    echo "No se ha realizado la distribución";
}
?>

<?php

}
elseif ($user['aprobador'] == $user_id && $user['estado'] == 1) {

?>
  <div class="container">
	  <h3>Aceptar Documento?</h3>
	  <button class="btn btn-md btn-success" onclick="aceptar(<?php echo $user['id_transferencia']?>, <?php echo $_SESSION['user_id'];?>)"><span class="glyphicon glyphicon-ok"></span></button>
	  <button class="btn btn-md btn-danger" onclick="rechazar(<?php echo $user['id_transferencia']?>, <?php echo $_SESSION['user_id'];?>)"> <span class="glyphicon glyphicon-remove"></span></button>
	</div>
<?php
}

?>

</div> 
</div>
</div>                 
 
<div class="modal fade" id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="largeModal1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
									
											<div class="modal-content">
												<div class="modal-header">
												<h4>Asistentes ingresados</h4>
													<button type="button" class="close" data-dismiss="modal" ></button>
													
												</div>
												<div class="modal-body1">

													<div class="row">
															<div class="col-md-4"></div>	
															
															
													</div>
													
												
												</div>
												<table class="table" width="100%">
															
															<thead>
															<th>ID</th>
															<th>Tipo</th>
															<th>Cantidad</th>
															<th>Nombre Asistente</th>
															<th>Cedula Asistente</th>
															<th width="30px;">Consentimiento</th>
															<th>Eliminar</th>
															</thead>
														
															
															<tbody id="columna" >
																
															</tbody>
															<input type="hidden" id="ide" value="<?php echo $user['id_transferencia']; ?>">
													</table>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
													
												</div>
											</div>
										</div>
									</div>
                      
        </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importar Codigos Inversion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="buscar();">
        </button>
      </div>
      <div class="modal-body">
      <div class="col-sm-6">
		  <div class="botonn">
		  <input type="hidden" name="dato" id="idd" value="<?php echo $sid; ?>">
									
	  <a href="importadorCodigos.php?ide=<?=$user['id_transferencia']?>" target="_blank" class="btn btn-azure">Importador</a>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
			<input type="text" placeholder="Codigo Inversion" class="form-control" id="codigo_inversion" name="codigo_inversion">
			<input type="number" placeholder="Porcentual" class="form-control" id="porcentaje" name="porcentaje">
		</div>
		</div>
</div>
      <div class="modal-footer">
		<button type="button" class="btn btn-success" data-dismiss="modal" onclick="ingresoCod()">Registrar</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="buscar();">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Codigos Inversion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
	  </div>
	  <div class="modal-body">
		  <div class="table-responsive">	
	  <table class="table " width="100%">
															
		<thead>
			<th>ID Factura</th>
			<th>Codigo Inversion</th>
			<th>Valores</th>
			
		</thead>
																										
		<tbody  id="trans_v1">
														
		</tbody>
		<input type="hidden" id="ide" value="<?php echo $user['id_transferencia']; ?>">
	</table>
	</div>
	  </div>
	  <div class="modal-footer">
		
	  </div>
    </div>
  </div>
</div>


<input type="hidden" id="porcentual" value="<?php echo $cond[0]['porcentual']?>">

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


<script>
$(document).ready(function () {
escanear();
  var items = <?= json_encode($array)?>
  
  $("#pan1").autocomplete({
		 source: items,
		 select: function (event, item) {
			 var params = { equipo:item.item.value};
			 $.get("getdatos2.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel1').val(json.id_cliente);
						if(json.transferenciaValor == "Si")
						{
							$('#alertaC').html('<div class="alert alert-success" role="alert"><h5>Tiene transferencia de valor</h5></div>');
						}
						else
						{
							$('#alertaC').html('<div class="alert alert-danger" role="alert"><h5>No tiene transferencia de valor</h5></div>');
						}
				 }
				 else
				 {

					$('#alertaC').html('<h5>No existe.</h5>');
				 }
			 });
		 },
		 minLength: 2
	});
	
	
  
	


	var opciones = <?= json_encode($arrayempleado)?>

	$("#empleados1").autocomplete({
		 source: opciones,
		 minLength: 2,
		 select:function (event, item) {
			 var params = { nombreempleado:item.item.value};
			 $.get("getdatos3.php", params, function (response) {
				 var json = JSON.parse(response);
				 if(json.status == 200)
				 {						
						$('#panel4').val(json.cedula);
						console.log(json);
				 }
				 else
				 {

				 }
			 });
		 }
  });


});


<?php
function eliminar_tildes($cadena){
 
	//Codificamos la cadena en formato utf8 en caso de que nos de errores
	$cadena = utf8_encode($cadena);

	//Ahora reemplazamos las letras
	$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
	);

	$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

	$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

	$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

	$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

	$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
	);

	return $cadena;
}


?>
		
				


    <?php

    require_once('../../pie.php'); 
    ?>