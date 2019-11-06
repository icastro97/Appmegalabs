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
            <a href="https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/listadolegalizacionesproceso.php?op=ABIERTAS" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
                 <br> 
				 <div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"></div>
						<div class="col-md-3"></div>
						

					</div>
    		<td >&nbsp;</td><td >&nbsp;</td>
		     </div>
		     
								</td>
              </tr>
						
              

              
            </table>
          
            
		     
          </form> 
            
            
         
            
                      
        </div>
        <div class="container">
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
<?php
    if($user['estado'] == '2'){
?>
<h2>Asignar Aprobador</h2>
<?php
    }
    
    else {
?>
<h2>Cambio Aprobador</h2>
<?php
}
?>
            <button data-toggle="modal" data-target="#edicion" class="btn btn-lg" style ="  background-color: #00965e; color: white;"><i class="glyphicon glyphicon-pencil" style ="font-size: 15px;"></i></button>    <br> <br>
												<input type="button" class="btn" style="background-color:#00AB84; color: white;" value="Enviar" onclick="enviar()">

        </div>
        <div class="col">
        <iframe src="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/uploads/<?php echo $user['fichero']?>"></iframe> 
        </div>
    </div>

        </div>
        
<div class="modal fade bd-example-modal-lg" id="edicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambio Aprobador</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body" style="padding: 10px;">
      
                          <div class="panel panel-default users-content" id="seleccion">
    <div class="panel-body">
	<div class="panel" style="border:1px solid #00AB84;" >            
			<div class="panel-heading text-center form-control" >Seleccion Aprobador</div> 

            <input name="docupdate" type="hidden" id="docupdate" value="<?=$_REQUEST['documento'];?>" />
			<td >&nbsp;</td>
			<td >&nbsp;</td>
			<div class="row">
                <div class="col-md-4" id="">
                <div class="col-md-6" id="apro1">               
                    </div>
</div>	       
				<input type="hidden" name="nombreaprobador" id="" value="<?php echo $apr[0]['u_userid']; ?>">	
				<input type="hidden" name="aproba" id="aproba" value="<?= $detalle[0]['aprobador']; ?>">
			</div>
			<div class="row">
				<div class="col-md-4" id=""></div>
				<div class="col-md-5" id="apro3" > <h4>El aprobador es : <strong><?php echo $apr[0]['full_name'] ?></strong></h4>

                <h5 align="justify">Por favor elegir el aprobador:<h5>
				<input type="text" class="form-control" id="listaapr"  name="aprobador" onKeyUp="listadoAprobadores()" onblur="prueba2();"  OnChange="prueba()" >
				<input type="hidden"  id="listaapr1" name="codigoAprobador">
                <input type="hidden"  id="listaapr2" name="cedulaAprobador">
         
				</div>				
				
			</div>			
			<div class="row">
			<div class="col-md-4" id=""></div>
			<div class="col-md-6" id="apro2">

            </div>			
			</div>
			<div class="row">
			<div class="col-md-4" id=""></div>	
			<div class="col-md-5" id="aprobadores">
				
							
			</div>			
			</div>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-5">
				<div id="valida"></div>
				</div>
			</div>
			

	</div>
	</div>
	</div>  

      
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>   
        
          <div class="row">
            <div class="col-md-3">
            
            </div>  
            <div class="col-md-2">
            
            </div>
            <div class="col-md-3">
            <h4 aling="justify">Observacion Aprobador:</h4>
            <h4 aling="justify"><strong><?php echo $user['observacionG']?></strong></h4>
            <?php
            if($user['corregido'] == 'true'){
                
            
            ?>
            <h6>Corregido <img src="https://image.flaticon.com/icons/svg/291/291201.svg" width="20px"> </h6>
            </div>
            <?php
            }
            else{
                
            }
            ?>
            <div class="col-md-2">
            
            </div>
            
            </div>
            </br>
            <?php
             if($user['observacionAc'] && $user['estado']=='APRC')
             {
                 
             
            ?>
            <div class="row">
            <div class="col-md-3">
            
            </div>  
            <div class="col-md-2">
            
            </div>
            <div class="col-md-3">
                
            <h4 aling="justify">Observacion Contabilidad:</h4>
            <h4 aling="justify"><strong><?php echo $user['observacionAc'];?></strong></h4>
            
            </div>
            <div class="col-md-2">
            
            </div>
            
            </div>
            </br>
            <?php
             }
             else
             {
                 
             }
            ?>
             
            
											<div class="row">
											  <div class="col-md-3">
												
												</div>  
											  <div class="col-md-3">
												
												</div>
												<div class="col-md-2">
												</div>
												<div class="col-md-2">
												
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
						$('#panel1').val(json.cedula);
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
		
						