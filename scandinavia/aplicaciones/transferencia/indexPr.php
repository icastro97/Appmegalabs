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
        $sid = "";   
        foreach($_REQUEST['documento'] as $key=>$value)
        {
            $hh = $value;
            $extrae =  $hh."' or Documento = '";	
            $sid = $sid . $extrae;
        }  
        $sid  = substr ($sid, 0, strlen($sid) - 18); //elimina la ultima,
        $sid  =  $sid  ;		
    }


    //load and initialize database class
    require_once '../../mcv5/clases/DB.class.php';
    $db = new DB();

    //get users from database
    $conditionsempresa['where'] = array('id '=> 1,); 
    $empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


    $bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

    $conditions['where'] = array('Documento'=> $sid,); 
    $users = $db->getRows('vw_basec_vendedores',$conditions); //ojo se pone tabla a consultar

    $condition['where'] = array('cedulaSesion'=> $cedulaSesion,); 
    $usuario = $db->getRows('matrizaprobacion',$condition);


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
<script src="mainIndex.js"></script>
<script src="pruebas.js"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="estilostranfer.css">



 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
            <a href="https://appmegalabs.com/scandinavia/default1.php?group=Transferencia" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
				 <br> 
				 <div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"></div>
						
						<input type="hidden" name="dato" id="id_cabeza" value="<?php echo $users[0]['id_cabeza']; ?>">

					</div>
          <section class="wrapper site-min-height">          
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>&nbsp;</p>
          		<section id="unseen">                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<p>
	  <?php } ?>
	</p> 
    
<h2 align = "center">Transferencia de Valor</h2>
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
    
   <form id="my-form" method="post"  name="insertregistro" enctype="multipart/form-data">
   		
	<div class="row">	
	<div class="col-md-3">
	    
			<input type="hidden" name="idu" id="idu" value="<?php echo $_SESSION['id']; ?>" >
			<input type="text" name "pri" id="pruebass" onKeyup="compara()"  class="form-control" placeholder="Codigo QR"><br>
			<select name="opciones" id="opciones" required onchange="esconde()" >
			    <option value="">Seleccione una opcion..</option>
			    <option value="ClienteF">Factura cliente Fisica</option>
			    <option value="ClienteE">Factura cliente Electronica</option>
			    <option value="Electronica">Factura electronica</option>
			    <option value="Fisica">Factura fisica</option>
			</select>
	
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-2">
	<input  type="text"  class="form-control" id="cambio" placeholder="Radicado" name="radicado" required  />
	</div>
        </div>	    
        
	</div>      
	
	<div class="panel panel-default users-content">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;" id="panelg">            
		
			
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>  
									      
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									  
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									
									<input name="identificacion"  id="identificacion" onKeyUp="empleado(1)"  onBlur="empleado2(1)" type="text" required="required" class="form-control"   placeholder="Identificación" value="<?php echo $users[0]['identificacion']; ?>"  disabled/>
									</div>
						
					</div>
					<div class="col-md-3">
									<div class="form-group">
									
									<input name="nombre" type="text" required="required" class="form-control" id="nombre"  placeholder="Nombres" value="<?php echo $users[0]['nombre']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-2">
									<div class="form-group">
									
									<input name="cargo" type="text" required="required" class="form-control" id="cargo"  placeholder="Cargo" value="<?php echo $users[0]['cargo']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-1">
									<div class="form-group">
									
									<input name="ctocto" type="text" required="required" class="form-control" id="ctocto" value="<?php echo $users[0]['ctocto']; ?>" disabled />
									</div>
					</div>
					
					
					
			</div>
			<div class="row">
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Linea</label>
									<input name="Linea" type="text" required="required" class="form-control" id="Linea"  placeholder="Linea" value="<?php echo $users[0]['linea']; ?>" disabled/>
									</div>
					</div>
					<div class="col-md-3">
									<div class="form-group">
									<label for="ex2">Area Terapeutica</label>
									<input name="Area" type="text" required="required" class="form-control" id="Area"  placeholder="Area" value="<?php echo $users[0]['area']; ?>" disabled/>        
									</div>
					</div>
					<div class="col-md-4">
						<label for="ex2">Observaciones</label>
						<div class="input-group">
							<textarea name="txtobservaciones" rows="3" class="form-control " id="txtobservaciones" placeholder="Observaciones" onchange="actualizarObservacion()" onclick="operaciones();" ><?php echo $users[0]['observaciones']; ?></textarea>
						</div>
		</div>
				</div>
			
				
		
		<input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
                <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /></p>
				<div id="apro"></div>
				<input name="docupdate" type="hidden" id="docupdate" value="<?=$_REQUEST['documento'];?>" />
				
	</div>
	

    
	
	<div class="panel" style="border:1px solid #00AB84;">   
	
	<div class="panel-heading text-center form-control" >Alta información</div>                    
			<td >&nbsp;</td>
			<td >&nbsp;</td>         
			     
              <div class="row">
			  <div class="col-md-1">
									<div class="form-group">
									    
									<input name="fechamos" type='hidden' required class="form-control" id="fechamos" placeholder="Fecha" min="" value = "<?php echo date("d/m/Y");?>" readonly="readonly"/>  
									</div>
					</div>
                   <div class="col-md-2">
			    			      <label for="ex2">Fecha</label>
			    			      
                                  <div class="input-group">	
								  <input type="text" class="form-control inputstl" name="fechasiguiente[]" id="dateArrival1" placeholder="Seleccionar Fecha" required>
								  </div>
					</div>                              
                                
                                
                    <div class="col-md-2">
			    			      <label for="ex2">Factura</label>
                                  <div class="input-group">			    			     
			    			      <input name="factura[]" class="form-control input-sm" id="factura1"  required="required" type="text" placeholder="Factura">
		    			          </div>
					</div>
                                

					<div class="col-md-2">
			    			      <label for="ex2">Nit</label>
                                  <div class="input-group">			    			     
			    			      <input name="nit[]" class="form-control" id="nit1" onKeyUp="valida(1)" onblur="valida()"  onchange="valida(1)"  required="required" type="text" placeholder="NIT">
		    					  </div>
					</div>                                
                                               
                                               
                    <div class="col-md-3">
			    			      <label for="ex2">Establecimiento</label>
                                  <div class="input-group">			    			     
			    			      <input name="establecimiento[]" class="form-control input-sm" id="establecimiento1" style="text-transform:uppercase" onclick="llenaNombre()" required="required" type="text" placeholder="Establecimiento">
		    			        </div>
					</div>                                       
            </div>                    
            <div class="row"> 
					<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
					</div>     
					
                  <div class="col-md-2">
			    			      <label for="ex2">Ciudad</label>
                                  <div class="input-group">
			    			     
			    			      <input name="ciudad[]" id="ciudad1" onKeyUp="ciudad(1)" class="form-control" style="text-transform:uppercase" required="required" type="text" placeholder="Ciudad">
		    			        </div></div>
                                
                            
                                
                     
                    <div class="col-md-2">
								  <label for="ex2">Tipo de Gasto</label>
								  
                                  <div class="input-group">
			    			     
			    			     <select name="TipoGasto[]" class="form-control input-sm" id="TipoGasto1" style="width: 180px; height:25px;"> <option value="Compras">Compras</option><option value="Otros Servicios">Otros Servicios</option><option value="Restaurante con Propina">Restaurante con Propina</option><option value="Restaurante sin Propina">Restaurante sin Propina</option><option value="Transportes Terrestres">Transportes Terrestres</option><option value="Transportes Aereos">Transportes Aereos</option><option value="Alojamiento">Alojamiento</option> </select>
		    			        </div></div>           
                               
                               
                    <div class="col-md-2">
			    			      <label for="ex2">Concepto</label>
                                  <div class="input-group">
			    			     
			    			     <select name="concepto[]" class="form-control input-sm" id="concepto1" style="width: 180px;height:25px;"> 
							<option value="Inversion comercial">Inv. comercial</option>
                </select>
								</div></div>  

								<div class="col-md-3">
			    			      <label for="ex2">Moneda</label>
			    			     <div class="input-group">
			    			      <select name="Moneda[]" class="form-control input-sm"  id="Moneda1" style="height:25px;"> <option value="COP">Peso Colombiano</option><option value="US">Dolares</option><option value="EUR">Euros</option> </select> 
		    			        </div>
                                </div>
								<input type="hidden" id="cufe" name="cufe"></input>
								
			</div>					
                  
            <div class="row"> 
			<div class="col-md-1"></div>
                  <td><div class="col-md-5">
			    			      <label for="ex2">Descripcion</label>
                                  <div class="input-group">
			    			      
			    			       <textarea name="descripcion[]" class="form-control input-sm" id="descripcion1"   rows="3" cols="45" required></textarea>	</div></div> 
                                   
                                   
                     
                                
								<div class="col-md-2">
			    			      <label for="ex2">Subtotal:</label>
                                  <div class="input-group">
                                   <span class="input-group-addon">$</span>                                                                    
                                   <input id="valor1" name="valorSinImpuestos[]" class="monto form-control currency" onclick="sumar()"  onkeyup="sumar();" type="text" required/>
									
                                            <br>
											</div></div>  
											<div class="col-sm-2" id="colorxd">
			    			      <label for="ex2">Iva</label>
                                  <div class="input-group">
                                   <span class="input-group-addon">$</span>                                                                    
                                   <input id="valor2" name="valorImpuesto[]" class="monto form-control currency" onclick="sumar()" onkeyup="sumar();" type="text" required/>
									
                                            
											</div>
											<br>
											<br>
</div>
								<div id="valoresgg">
			    			      <label for="ex2">Impuesto al consumo:</label>
			    			      
			    			      	 <div class="input-group" >
                                   <span class="input-group-addon">$</span>                                                                    
                                   <input id="valor3" name="valorIca[]" class="monto form-control currency" onclick="sumar()" onkeyup="sumar();" type="number"/>
									</div>
									</div>										
											
								   

									
											
										       
            </div>                      
                                  
            <div class="row">
            <div id="tipo" ></div>  
					<div class="col-md-1">
									<div class="form-group">   
									</div>
					</div>
                  <div class="col-md-3">
			    			      <label for="ex2">Soporte</label>
                                  <div class="input-group">			    			     
			    			      <input name="file[]" required="required" type="file" id="file1">
		    			        </div></div>
                		
				<div class="col-md-2"></div>
			
			<div >
			
						<h3>Total:</h3>
					<!-- <input type="text" name="" id="total"> -->
				
			</div>	
			
			<h3 id ="total"></h3>
            </div>
			<td >&nbsp;</td>
			<td >&nbsp;</td>				
	</div>
</div>
<div class="row">
			 	<div class="col-md-1">
									<div class="form-group">
									<input  type="hidden"  class="form-control"/>        
									</div>
				</div>   
				<input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>" />
				<input type="hidden" name="ultimoinserted" id="ultimoinserted" value="" />
				
				<input type="hidden" id="lgcabeza" value="<?= $users[0]['id_cabeza']; ?>">
				<div class="col-md-3">
					<input name="input" type="submit" id="buttonsave" class="btn input" style="background-color:#00AB84; color:white;" value="Añadir"/> 
					
				</div>
			</div>
           
	
			<td >&nbsp;</td>
			<td >&nbsp;</td> 
             
			<div class="table-responsive table-bordered">  
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
              
                <td colspan="2"><div id="resultado">
                 
                </div></td>
              </tr>
           
              
            </table>
            </div>
            
            

            
            <p>&nbsp;</p>
            
            
       
            
            
          </form> 
            
            
         
            
                      
        </div>
</div>
</div>                  
				


    <?php

	require_once('../../pie.php'); 
	}
    ?>