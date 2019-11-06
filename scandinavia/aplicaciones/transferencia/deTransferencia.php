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
	
	$condicione['where'] = array('id_transferencia'=> $sid,); 
	$cons = $db->getRows('transferencia_val',$condicione);

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
    .pointers
    {
        cursor: pointer;
    }
</style>
 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/listados/aprobador/index.php?op=Aprobacion" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
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

						 
								<table class="table table-striped table-bordered ">
								
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
										<th rowspan="2" valign="bottom"><div align="center">Asistentes</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Suma de asistentes</div></th>
										<th rowspan="2" valign="bottom"><div align="center">Ver</div></th>
										
										
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
										    
											<?php 
											 $uno =  $user['valorSinImpuesto']; 
											 
											 ?>
											
											<?php if ($user['estado'] == "ACEPTADO" || $user['estado'] == "APR") {
										
											 ?>
										<a href="" class="btn btn-primary botonarr" data-toggle="modal" data-id="<?php echo $usuario?>" data-toggle="modal" data-target="#exampleModal"><i class="glyphicon glyphicon-plus"></i></a>
										<input type="hidden" id="id_tr" value="<?=$user['id_transferencia'];?>">
										<?php
										$sqls = "SELECT sum(porcentual) as porcentuales FROM codigosinversion where id_factura = ".$user['id_transferencia'];
										
										$querys = mysqli_query($mysqli, $sqls);
										while($row = mysqli_fetch_array($querys))
										{
										    $re = $row['porcentuales'];
										}
										
									
                                        $sql2 = "SELECT sum(valor) as valor FROM codigoSi where id_factura = ".$user['id_transferencia']." and tipo = 'SI' ";
                                        $ejecucion2 = mysqli_query($mysqli, $sql2);
                                        while($row = mysqli_fetch_array($ejecucion2))
                                        {
                                            $comparacion = $row['valor'];
                                        }
		    
										
										
										
										
										$sql = "SELECT * FROM codigosinversion where id_factura = ".$user['id_transferencia'];
										$query = mysqli_query($mysqli, $sql);
										$numero = mysqli_num_rows($query);
										
										if($numero > 0)
										{
										    
										?>
										<a href="" class="btn btn-primary botonarr" data-toggle="modal" data-id="<?php echo $usuario?>" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="traecodigos(<?php echo $user['id_transferencia'];?>)"><i class="glyphicon glyphicon-zoom-in"></i></a>
										<input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#largeModal">
										<?php
										}
										else
										{
										    
										}
										?>
										<?php
										}
										else{
											echo "";
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
										
									
										<?php 
										if($user['tipoCodigo'] == "SI")
													{
										?>
										
										
										<td align="center">
										
										<?php

										
										 

												$consulta="SELECT Cliente FROM medicos WHERE cedula_usuario = ". $cedulaSesion;
												$sql = mysqli_query($mysqli, $consulta);
													
												$array = array();
													while($row = mysqli_fetch_array($sql))
													{
														$equipo = utf8_encode($row['Cliente']);														
														array_push($array, $equipo);
													}


											?> 	
										<?php
									 if ($user['estado'] == "ACEPTADO" || $user['estado'] == "APR") {
										
											 
										$usuarios = $user['id_transferencia'];
											echo "<input type='hidden' id='$usuarios' value='$usuarios'>"; 
										?>
										<a href="" class="btn btn-primary monohp" data-toggle="modal" data-id="<?php echo $usuarios;?>" data-target="#largeModal"><i class="glyphicon glyphicon-plus"></i></a>										
										
										<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Módulo asistencia</h4>
														<button type="button" class="close" data-dismiss="modal"></button>
													</div>
													<div class="modal-body" >
														<div class="row">
															<div class="col-md-4">
																<input type="hidden" name="panel" id="panel" onChange="deshabilitarUno()">
																<input type="hidden" id="idhp" value="<?php echo $user['id_transferencia']; ?>">
																					

															</div>
																														
															<div class="col-md-5 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan1" placeholder="Nombre del médico">
																<div id="alertaC"></div>
																<input type="hidden" name="cedulapanel1" id="panel1">
																<input type="hidden" name="" id="panel2">
																<input type="hidden" name="" id="panel3">
																
															</div>
															<div class="col-md-3">
															    <div class="input-group">
															    
															    <input type="text"  class="form-control currency"  id="val" placeholder="Valor" onKeyup="pruebaaa()">
															    <input type="hidden" id="prus1">
															    
															    </div>
															</div>
                                                    

														<!-- Inicio Panel General -->
													
															<div class="col-md-4">
																<input type="checkbox" name="panelCompleto" id="panelcom" onChange="deshabilitarSeis()">
																
																<h5>Panel Megalabs</h5>						

															</div>
																														
															<div class="col-md-3 ui-front" >
																<input type="text" name="paneles"  class="form-control" id="pan2" placeholder="Cédula del médico" onkeyup="buscarCC()">
																<div id="alertaC"></div>
																
																<input type="hidden" name="" id="panel4">
																<input type="hidden" name="" id="panel5">
															</div>
															<div class="col-md-4">
																	
																	
															<input type="text" name="cedulapanel2" id="panel10" class="form-control" placeholder="Nombre del médico">
															<br>
															
															<div class="input-group" >
															    
															    <input type="text"  class="form-control "  id="val1" placeholder="Valor" onKeyup="pruebaaa1()">
															    <input type="hidden" id="prus">
															    
															    </div>
																	
															</div>
														<!-- Fin Panel General -->


														<div class="col-md-4">
															<input type="checkbox" name="nopanel" id="nopanel" onClick="deshabilitarDos()" >
															<h5>No panel</h5>
														</div>
															<div class="col-md-4">
																	
															<input type="text" name="nopaneles2" class="form-control"  id="nopaneles2" placeholder="Cédula" onkeyup="prueba()">
															<div id="alertaT"></div>
															</div>
															<div class="col-md-3">
																	
																	
																	<input type="text" name="nopaneles" class="form-control"  id="nopaneles1" placeholder="Nombre Médico">
																	<br>
																	
																	
															
															
															    
															    <input type="text"  class="form-control currency"  id="val2" placeholder="Valor" onKeyUp="pruebaaa2()">
															    <input type="hidden" id="prus2">
															    
															    
																	
															
															
															
																	
															</div>
															
															<?php

										
										 

																$consulta="SELECT nombres FROM empleadolg";
																$sql = mysqli_query($mysqli, $consulta);
																	
																$arrayempleado = array();
																	while($row = mysqli_fetch_array($sql))
																	{
																		$nombreempleado = utf8_encode($row['nombres']);														
																		array_push($arrayempleado, $nombreempleado);
																	}


																?> 	
														
														<div class="col-md-4">
															<input type="checkbox" name="empleado" id="empleado" onClick="deshabilitarTres()" >													
															<h5>Empleado</h5>																										
														</div>
															<div class="col-md-4">
																	<input type="text" name="empleados" class="form-control"  id="empleados1" placeholder="Nombre Empleado">
																	
																	<input type="hidden" name="cedulaempleado" id="panel4e">
																	
															</div>
														<div class="col-md-3">
																	
																	
																	<input type="text"  class="form-control currency"  id="val3" placeholder="Valor" onKeyup="pruebaaa3()">
																	<input type="hidden" id="prus3">
																	
																	
															</div>
															
														<!-- inicio codigo  Importador -->
														
															<div class="col-md-1">
																																									
															</div>
																<div class="col-md-4">
																		
																		<input type="checkbox" name="importador" id="importadorM" onClick="deshabilitarCuatro()" >													
																		<h5>Importador</h5>	
																</div>
																<div class="col-md-4">
																<a href="importadorAsistentes.php?ide=<?=$user['id_transferencia'];?>" target="_blank" id="importador1" class="btn btn-azure">Importador</a>
																
																</div>
																<div class="col-md-1">																																								
															</div>
														<!-- Fin codigo  importador -->	

														<!-- inicio codigo  farmacias -->

															<div class="col-md-4">
															<input type="checkbox" name="farmacia" id="farm" onClick="deshabilitarCinco()" >													
															<h5>Farmacias</h5>																										
														</div>
															<div class="col-md-2">
																	<h5 id="cantidad">Cantidad:</h5>
																	<input type="number" name="numero" class="form-control form-control-sm"  id="num" placeholder="Cantidad">
															</div>				
														<!-- fin codigo  farmacias -->
												
											</div>

											<!-- Modal footer -->
											<div class="modal-footer">		
                                          	      								
												<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="registrar()">Registrar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
											</div>
											
											</div>
											</div>
										</div>
										</div>
										
										</td>
										<td align="right"><?=$user['moneda']?> $<?=number_format($comparacion,2)?></td>	
												<?php

													}
											?>	
										
										
										<?php
										$identificadorDet = $user['id_transferencia'];		
										$sqls = "SELECT identificadordet from asistencia_trans_valor where identificadordet = ". $identificadorDet;					
										$query = mysqli_query($mysqli, $sqls);
										$numeros = mysqli_num_rows($query);
										
										$asistencia = $user['asistencia'];							
                                        
                                        if($user['estado'] == "1")
                                        {
                                            echo "<td align='center'></td>";
                                        }
                                        else       
                                        {
        										if($asistencia != "" && $numeros > 0)
        										{	
        										
        										echo "<td align='center'> <a href='mostrarAsistentes.php?documento=$identificadorDet' class='btn' style='background-color:#00AB84;'><i class='menu-icon glyphicon glyphicon-search' style='color:white;'></i></a> </td>";
        										
        										
        										}	
                                        }
									}
									else {
										echo " ";
									}									
										?>
										
										
									
										
									</tr>
									
									
									<?php endforeach; else: ?>
									<tr>
										<td colspan="7">No existen documentos para mostrar......</td>
									</tr>
									<?php endif; ?>
									
									
                               <tr>
							   <?php
							   $cabeza = $detalle[0]['id_transferencia'];
							     $cons = "SELECT id_transferencia, asistencia, tipoCodigo FROM `transferencia_val` WHERE id_transferencia = '$cabeza'";
								
								$que = mysqli_query($mysqli,$cons);
								
								while($row = mysqli_fetch_assoc($que))
								{
								 	$tipoCodigo =  $row['tipoCodigo'];	
									
														
								}
							   $sql = "SELECT id_transferencia, asistencia, tipoCodigo FROM `transferencia_val` WHERE id_transferencia = '$cabeza'  and asistencia IS NULL and tipoCodigo = 'SI'";
							   $query = mysqli_query($mysqli,$sql);
								
								while($row = mysqli_fetch_assoc($query))
								{
									$ids =  $row['id_transferencia'];	
									
														
								}
							   foreach ($detalle as $key) 
							   {
									$identificadordetlg = $key['id_transferencia'];   
									
									
									$sqla = "SELECT * FROM `asistencia_trans_valor` WHERE identificadordet IN('$identificadordetlg')";									
									$querys = mysqli_query($mysqli,$sqla);
									
									$resultado = mysqli_num_rows($querys);
								
								}	
								?>
								
							  </tr>
							  
							  
								</tbody>
								
								<tbody>

								</tbody>
								
									
									
								</table>
							

								</div> 

                </div>
								</td>
              </tr>
						
              

              
            </table>
            

            
		     
          
            
            

 
            
                      
		</div>
		
		
		<?php
		    $sql = "SELECT sum(valor) as valores FROM asistencia_trans_valor where identificadordet =". $cabeza;
		    $ejecucion = mysqli_query($mysqli, $sql);
		    while($row = mysqli_fetch_array($ejecucion))
		    {
		        $valores = $row['valores'];
		    }
		    
		    $sql1 = "SELECT sum(porcentual) as porcentuales FROM codigosinversion where id_factura = ".$cabeza;
		    $ejecutar = mysqli_query($mysqli, $sql1);
		    while($row = mysqli_fetch_array($ejecutar))
		    {
		        $valorCodigos = $row['porcentuales'];
		    }
		    
		    
		 
		    
		?>
		
		
<div class="container">		
<?php
if($detalle[0]['estado'] == "ACEPTADO")
{
    if($uno == $re)
    {
       
    ?>
    
    
    <div class="alert alert-success" role="alert" >
    <h6>La base equivalente a los valores ingresados.</h6>
    </div>
    
    <?php
    }
    else
    {

    ?>
    
    <div class="alert alert-danger" role="alert">
    
    <h6>La base no es equivalente a los valores ingresados.</h6>
    </div>
    <?php
    }
    
}
else
{
    
}
?>
 

		
		<?php
if($user['aprobador'] == $user_id && $user['estado'] == "ACEPTADO" )
{
     
    
	?>
 
	<div class="container">
	   
	    
	    <?php
	       if($user['pago_especial'] == "true")
	       {
	           
	    ?>
	    <h6>Pago especial <a class="pointers" onclick="regresarCheck()"><img src="https://image.flaticon.com/icons/svg/291/291201.svg" width="20px" ></a> </h6>
	    <?php
	       }
	       else
	       {
	           
	    ?>
	    <h6><input type="checkbox" id="pEspecial" onClick="checkeadoPago()"> Pago especial</h6>
	    <?php
	       }
	    ?>
	    
	    <?php
	    if($user['facturaDeposito'] == "true")
	    {
	    ?>
	    
	    <h6>Factura Deposito <a class="pointers" onclick="regresarCheck2()"><img src="https://image.flaticon.com/icons/svg/291/291201.svg" width="20px" ></a></h6>
	    
	    
	    <?php
	    }
	    else
	    {
	    ?>
	    
	    <h6> <input type="checkbox" id="fDeposito" onClick="checkeadoDeposito()" > Factura Deposito</h6>
	    

	    <?php
	    }
	    ?>
	    
	    
	    	    <?php
	    if($user['inv_comercial'] == "true")
	    {
	    ?>
	    
	    <h6>No Inversion Comercial <a class="pointers" onclick="regresarCheck3()"><img src="https://image.flaticon.com/icons/svg/291/291201.svg" width="20px" ></a></h6>
	    
	    <?php
	    }
	    else
	    {
	    ?>
	    
	    <h6> <input type="checkbox" id="noInv" onClick="checkeadoNoInv()"> No Inversion Comercial</h6>
	    
	    <?php
	    }
	    ?>
	    
	    <button class="btn btn-danger" onclick="deshacerEstado(<?= $user['id_transferencia'];?>, <?php echo $_SESSION['user_id'];?>)"><i class="glyphicon glyphicon-repeat"></i></button>
	    <br>
	    <br>
	    <div class="col-md-4" style="margin-left:-15px">
	    
        <form id="formulario" method="post" name="formulario" enctype="multipart/form-data" autocomplete="off">
        <input  class="form-control-file" type="file" id="multiFiles" name="files" required/>
        <br>
        <input class="form-control" name="nombreArchivo" placeholder="Nombre del archivo" required>
        <br>
        <button class="btn btn-primary" id="upload">Adjuntar</button> 
        
        <input type="hidden"  name="transfer" id="docs" value="<?php echo $user['id_transferencia'];?>">
        </form>	
	    </div>
	    <div class="col-md-3"></div>
	    <div class="col-md-3">
	    <?php
         $cc = "SELECT id_archivo, nombreArchivo, ruta_Archivo, tipo_archivo FROM archivos_facturas where id_factura = ".$user['id_transferencia'];
         //var_dump($cc);
         $resultado = mysqli_query($mysqli, $cc);
         
        ?>
        <table class="tablaarchivos table" style="margin-top:-150px; margin-left:213px">
        <tr>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Eliminar</th>
            
        </tr>
          <?php
        while($row = mysqli_fetch_assoc($resultado))
            {
          ?>
        <tr>
     <?php
           echo "<td align ='center'>".$row['nombreArchivo']."</td>"; 
           
											if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "image/png")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' /></a></td>"; 
												
											}  
											else if ($row['tipo_archivo'] == "application/pdf")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' /></a></td>";                   
											}
											else if($row['tipo_archivo'] == "image/jpg" || $row['tipo_archivo'] == "image/jpeg")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' /></a></td>"; 
											}	
											else if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
											{
												echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "application/vnd.ms-excel")
											{
													echo "<td> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' /></a></td>";
											}
											
											
           
        echo "";
        ?>
        <td><button class='btn btn-danger' onclick='eliminarImagen(<?php echo $row['id_archivo'] ?>)'><i class='glyphicon glyphicon-trash'></i></button></td>
        </tr>
        
        <?php
            }
            ?>
        </table>    
       
	    </div>
    
	    
	    
	    
	    <br>
	    <br>
        <br>
        <div class="col-md-5">
            
         
        </div>  
        <div class="col-md-3">
        
        </div>  
        <div class="col-md-3">
         
       
        </div>  
        </div> 
        <input type="hidden" id="aprContabilidad" value="354"> 
        <input type="hidden"   id="docs" value="<?php echo $user['id_transferencia'];?>">
        <input type="hidden" value="<?php echo $_SESSION['user_id'];?>" id="sesionAprobador">
	    <br>
	<label for="success" class="btn btn-success">Novedad en Documento<input type="checkbox" id="success" class="badgebox" onchange="checkapr();"><span class="badge">&check;</span></label>
	
	<div id="aprobar">
	    
	    <?php
	    if($user['novedad'] !== NULL || $user['novedad'] == '')
	    {
	        
	    ?>
	    <textarea name="ObservacionP" cols="40" rows="3" id="ObservacionN" class="form-control form-control-lg" placeholder="Observacion"><?= $user['novedad'];?></textarea>
	    
	    <?php
	    }
	    else
	    {
	        
	     ?>
	    <textarea name="ObservacionP" cols="40" rows="3" id="ObservacionN2" class="form-control form-control-lg" placeholder="Observacion"></textarea>     
	     <?php
	    }
	    ?>
	    
	
  </div>
  


  <table width="70%" border="0" class="table table-striped">
             
              <tr>
                <td width="23%" align="right"><h5>Estado:</h5></td>
                <td><label for="estadosTrans"></label>
                  <select  name="estadosTrans" id="estadosTrans" class="form-control form-control-lg">
                    <option value="APR">APROBADO</option>
                    
                  </select></td>
              </tr>
              <tr>
                <td><input name="pasaguid" type="hidden" id="pasaguid" value="<?=$consultaguid?>" /></td>
      
                <td>
                    
                              	    <?php
	    if($user['observacion'] !== NULL || $user['observacion'] == '')
	    {
	    ?>
	    
	    <textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"><?= $user['observacion'];?></textarea>
	    <?php
	    }
	    else
	    {
	     ?>
	    <textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"></textarea> 
	     
	     <?php
	    }
	    ?>
                </td>
              </tr>
                
              <tr>
                  
              
                  
				<td>&nbsp;</td>
				<?php
				if($uno == $re &&  $numeros == "" && $tipoCodigo == "" || $tipoCodigo == "NULL")
				{
				    
			       
				?>
				<td><input type="button" onclick="procesar(estadosTrans, ObservacionP, <?php echo $user['id_transferencia'];?>, <?php echo $_SESSION['user_id'];?>)" name="Aprobar" id="Aprobar" value="Procesar" class="btn" style="background-color:#00AB84; color: white;" /></td>
				
				<?php
				}
				else if($tipoCodigo == "SI" && $numeros > "0" && $valores == $comparacion)
				{
				  
				
				  
				?>
				<td><input type="button" onclick="procesar(estadosTrans, ObservacionP, <?php echo $user['id_transferencia'];?>,<?php echo $_SESSION['user_id'];?>)" name="Aprobar" id="Aprobar" value="Procesar" class="btn" style="background-color:#00AB84; color: white;" /></td>
				<?php
				}
				else if($user['inv_comercial'] == "true")
				{
				    
				
				?>
				<td><input type="button" onclick="procesar(estadosTrans, ObservacionP, <?php echo $user['id_transferencia'];?>,<?php echo $_SESSION['user_id'];?>)" name="Aprobar" id="Aprobar" value="Procesar" class="btn" style="background-color:#00AB84; color: white;" /></td>
				<?php
				}
				else
				{
				     
				    
				?>
				<td><input type="button"  value="Procesar" class="btn" style="background-color:#00AB84; color: white;" disabled/></td>
				<?php
				}
				?>
				
              </tr>
            </table>
  </div>
 

<?php

}
elseif ($user['aprobador'] == $user_id && $user['estado'] == 1) {
    

?>
  <div class="container">
      <textarea placeholder="Observaciones" id="obser"></textarea>
	  <h3>Aceptar Documento?</h3>
	  <button class="btn btn-md btn-success" onclick="aceptar(<?php echo $user['id_transferencia']?>, <?php echo $_SESSION['user_id'];?>, $('#obser').val())"><span class="glyphicon glyphicon-ok"></span></button>
	  <button class="btn btn-md btn-danger" onclick="rechazar(<?php echo $user['id_transferencia']?>, <?php echo $_SESSION['user_id'];?>, $('#obser').val())"> <span class="glyphicon glyphicon-remove"></span></button>
	</div>
  
<?php

}

?>

</div> 
</div>
</div>                 
 
<div class="modal fade" id="largeModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">										<div class="modal-dialog modal-lg">
									
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
															<th>Valor</th>
															<th width="30px;">Consentimiento</th>
															<th>Eliminar</th>
															</thead>
														
															
															<tbody id="columna">
																
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
			 <div class="input-group">
                                   <span class="input-group-addon">$</span>    
			<input type="text" placeholder="Valores" class="form-control currency" id="porcentaje" name="porcentaje" onKeyUp="porcent()">
            
            
            <input type="hidden" id="porce">
            </div>
		</div>
		</div>
</div>
      <div class="modal-footer">
		<button type="button" class="btn btn-success" data-dismiss="modal" onclick="ingresoCod()">Registrar</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="">Cerrar</button>
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
			<th>Aplica</th>
			<th>Eliminar</th>
		</thead>
																										
		<tbody  id="trans_v">
														
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
						$('#panel4e').val(json.cedula);
						
				 }
				 else
				 {

				 }
			 });
		 }
  });


 $("#formulario").submit(function(e) {
        e.preventDefault();
        $.ajax( {
            url: "insertaImagen.php",
            method: "post",
            //data: $("form").serialize(),
            data: new FormData( this ),
            processData: false,
            contentType: false,
            dataType: "text",
            success: function(response) 
            {
                
                if(response > 0)
                {
                  //console.log("si");
                  
				  swal("La imagen se subio satisfactoriamente", {
								icon: "success",
								}).then((success)=>{
									actualizar();
								});
                }
                else
                {
                  //console.log("no");   
                  swal("Error al intentar eliminar!", {
								icon: "error",
								}).then((success)=>{
									actualizar();
								});
                }
            }
        });
    });


});

function actualizar(){location.reload(true);}

function deshacerEstado(identificador, user)
{
    $.ajax({
      url:'deshacerEstado.php',
      data:{identificador, user},
      type: 'POST',
      success:function(response)
      {
          if(response == "Exito")
          {
              actualizar();
          }
          else
          {
              alert('No se actualizo el estado');
          }
      }
    }); 
}


function eliminarImagen(id)
{
    
			swal({
			title: "¿Esta seguro/a de eliminar esta imagen?",
			text: "",
			icon: "warning",					
			buttons: true,
			dangerMode: true,
			}).then((result) => {
				if (result == true) {
					$.ajax({
						url:'eliminarImagen.php',
						type:'POST',
						data:{id},
						success: function (response) {

							if(response == "true")
							{
								swal("Se ha eliminado la imagen satisfactoriamente", {
								icon: "success"
								});
								actualizar();
								
								
								
								
							}
							else
							{
								swal("Error al intentar eliminar!", {
								icon: "Error",
								}).then((success)=>{
									actualizar();
								});
								
							}
							
						}
					});
					
				} else {
					swal("Cancelado!",{ icon:'error'}).then((success)=>{
						actualizar();
					});;
					
				}
				});				
								
         
}


function regresarCheck()
{
    let id_factura = $('#id_tr').val();
    $.ajax({
        url:'deshacerCheck.php',
        data:{id_factura},
        type:'POST',
        success:function(response)
        {
           if(response == true)
            {
                 swal("Se realizo el cambio correctamente!", {
								icon: "success",
								}).then((success)=>{
									actualizar();
								});
            }
            else
            {
                swal("Error al intentar cambiar!", {
								icon: "error",
								}).then((success)=>{
									actualizar();
								});
            }
        }
    });
}

function regresarCheck2()
{
    let id_factura = $('#id_tr').val();
    $.ajax({
        url:'deshacerCheck2.php',
        data:{id_factura},
        type:'POST',
        success:function(response)
        {
            if(response == true)
            {
                 swal("Se realizo el cambio correctamente!", {
								icon: "success",
								}).then((success)=>{
									actualizar();
								});
            }
            else
            {
                swal("Error al intentar cambiar!", {
								icon: "error",
								}).then((success)=>{
									actualizar();
								});
            }
        }
    });
    
    
}


function regresarCheck3()
{
   let id_factura = $('#id_tr').val();
    $.ajax({
        url:'deshacerCheck3.php',
        data:{id_factura},
        type:'POST',
        success:function(response)
        {
            if(response == true)
            {
                 swal("Se realizo el cambio correctamente!", {
								icon: "success",
								}).then((success)=>{
									actualizar();
								});
            }
            else
            {
                swal("Error al intentar cambiar!", {
								icon: "error",
								}).then((success)=>{
									actualizar();
								});
            }
        }
    });
    
}




</script>
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