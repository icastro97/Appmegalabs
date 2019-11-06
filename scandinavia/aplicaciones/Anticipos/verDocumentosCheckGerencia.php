<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$parametro = $_REQUEST['id'];
$cedulaAnticipo = $_REQUEST['cedula'];
$cedulaLogueada = $_SESSION['identificacion'];
$sesionLogueada = $_SESSION["user_id"];


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

//get users from empresa
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar

//cabeza de recibo
$conditionscabeza['where'] = array('consecutivo'=> $parametro,); 
$cabeza = $db->getRows('anticipo',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$detalle = $db->getRows('anticipo',$conditionsdetalle); //ojo se pone tabla a consultar

//totales por moneda
$conditionstotales['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$totalesdetalle = $db->getRows('vw_totanticipos',$conditionstotales); //ojo se pone tabla a consultar

$condicional1['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$menor = $db->getRows('totalAnticipos',$condicional1); //ojo se pone tabla a consultar



//detalle soportes
$sql20= "SELECT
`type`,
`ico`,
identificacion,
consecutivo,
`tipoArchivo`,
`pdf`
FROM
anticipo T1
INNER JOIN rc_mime T2 ON
T1.id_anticipo = " . $parametro;
$Obser=mysqli_query($mysqli, $sql20);
$row_Obser = mysqli_fetch_assoc($Obser);
$rowcount=mysqli_num_rows($Obser);



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

<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.rtl.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.rtl.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.rtl.min.css"/>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../assets/css/estilos.css">


<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">


<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.min.css"/>
	
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem; }
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.formato{font-size:96%;}
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}
</style>

<link rel="stylesheet" type="text/css" href="../../assets/css/estilos.css">


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
    

<a href="http://appmegalabs.com/scandinavia/aplicaciones/Anticipos/moduloGerencia.php?op=Gerencia" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
         <br>
         <br>                  
                  
<div class="container">
    <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
	<div class="alert alert-success"><?php echo $statusMsg; ?></div>
	<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
	<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
	<p>
	  <?php }  ?>
	</p> 
  <form action="apruebalg.php" method="get">
  <table width="80%" border="0">
  <tr>	    
	    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117"  /></td>
      <td colspan="2" align="center"><h3>Solicitud de Anticipos</h3></td>
	    
	  </tr>
    </table>
    <div class="panel-body">
  <div class="panel panel-default users-content">
    <div class="panel" style="border:1px solid #00AB84;">
    <div class="panel-heading text-center form-control" >Información General</div>
	<table width="100%" border="0"> 
  
	  <tr>	    
	    <td class="formato" colspan="5" align="center"><strong>Tipo:</strong> <?php echo $cabeza[0]['tipo']; ?></td><td >&nbsp;</td> <td class="formato" colspan="5" align="left"><strong>Identificacion: </strong><?php echo $cabeza[0]['identificacion']; ?></td> 
      <td class="formato" colspan="6" align="center"><strong>Anticipo:</strong> <?php echo $cabeza[0]['consecutivo']; ?></td>
     
	  <tr>	 
	    
	  </tr>
	 <tr>
     <td class="formato" colspan="5"></td><td class="formato" colspan="5"></td>
   </tr>
   <tr>
     <td class="formato" colspan="5" align="center"><strong>Fecha:</strong> <?php echo $cabeza[0]['fechaActual']; ?></td><td >&nbsp;</td><td class="formato" colspan="5" align="left"><strong>Nombre: </strong><?php echo $cabeza[0]['nombre']; ?></td>
   </tr>
   <tr>
   <td width="20%" class="formato" colspan="5"></td><td >&nbsp;</td>   <td class="formato" colspan="5"></td>
   </tr>
   
	  </table>	
    
	  
            
              <input name="useridl" type="hidden" id="useridl" value="<?=$_SESSION['id'];?>" /> 
              <input name="namel" type="hidden" id="namel" value="<?=$_SESSION['session_name'];?>" /> 
            </div>
            <div class="table-responsive">
            <table class="table table-striped ">
            <tbody id="userData">
           
            </tbody>
            <thead>
            <tr>
                <th rowspan="3"></th>
               
                <th rowspan="3" valign="bottom"><div align="center">Fecha</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Tipo</div></th>
                <th rowspan="3" align="center" ><div align="center">Identificacion</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Nombre </div></th>                
                <th rowspan="3" valign="bottom"><div align="center">Valor</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Adjunto</div></th>
                
              </tr>
              <tr></tr>
            </thead>
            <tbody id="userData2">
              
              <?php $sumaneto = 0;
					if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
              <tr>
              <td>&nbsp;</td>
               
                <td align="center"><?php echo $user['fechaActual']; ?></td> 
                <td align="center">
                  <?=($user['tipo']) ?></td>
                <td align="center">
                  <?=($user['identificacion']) ?></td>                
                <td align="center">
                  <?=$user['nombre']; ?></td>
                           
                               
                <td align="center"><?=$user['moneda']?> $<?=number_format($user['monto'], 2); ?></td>
                
         
                <?php    
                if($user['tipo'] == "Proveedor")
                {
                  if($user['archivo'] != "img_" )
                  {
                       ?>
                    <td align="center"><?php echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/ico_png.png\" alt=\"" . $row_Obser['archivo']. "\" width=\"20\" height=\"20\" />"; ?></td>                                       
                   <?php
                  }
                  else
                   {
                        ?>
                    <td align="center">No hay archivo</td>                                       
                   <?php
                        
                   
                   }
                }
                else 
                {
                  if($user['archivo'] != null)
                  {?>
                  <td align="center"><?php echo "<a href=\"" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/ico_pdf.png\" alt=\"" . $row_Obser['archivo']. "\" width=\"30\" height=\"30\" />"; ?></td>                                       
                  <?php  
                  }
                  else
                  {?>
                    <td align="center">No hay archivo</td>                                       
                   <?php 
                  }
                }
                ?>
                   <?php $sumaneto = $sumaneto + $user['monto'];?>
              </tr>
              <?php endforeach; else: ?>
              <tr>
                <td colspan="5">No existen documentos para mostrar......</td>
              </tr>
              <?php endif; 
			  $saldocontrol = $cabeza[0]['valoranticipo'] -  $sumaneto;
			  if($cabeza[0]['valoranticipo'] != 0){
			  	$sumatotal = $saldocontrol;
			  }else{
			  	$sumatotal = $sumaneto;
			  }
			  
			  ?>

            </tbody>
            <tbody>
            </tbody>
           
            </table> </div>
    <br />
<br />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
              <div class="row">
                     <div class="col-md-1">
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ex2" aling="center">Descripción:</label>
                            <textarea id="des" name="txtobservaciones" rows=4 class="form-control " id="txtobservaciones" readonly><?=$cabeza[0]['descripcion']?> </textarea>
                        </div>
                    </div>    
                   
                
                
                    
                  <div class="col-md-4">
                      
                        <div class="form-group">
                           
                            <h2 aling="center">Total</h2>
                            <hr align="left" noshade="noshade" size="2" width="45%" />
                                 <?php $sumavalores = 0; $arraymonedas = "";
                    					if(!empty($totalesdetalle)): $countyer = 0; foreach($totalesdetalle as $usertotdetalle): $countyer++; ?>
                                     
                                     
                                  <div class="col-md-3">
                                      <div align="left"><strong>Moneda:</strong> <?php echo $usertotdetalle['moneda']; ?></div>
                                    <div align="left"><strong>Valor:</strong> $<?=number_format(($usertotdetalle['sum(monto)']), 2)?></div>
                                    
                                  </div>
                                 
                                  <?php 

                            $salarioMinimo = 828116;
                             
                    			  $arraymonedas = $arraymonedas . ", " . $usertotdetalle['moneda'] . "$" . number_format(($usertotdetalle['sum(monto)']), 2);
                    			  endforeach; else: ?>
                                  <div class="col-md-3">
                                    <td colspan="5">No existen valores para mostrar......</td>
                                  </div>
                                    <?php endif; ?>
                                </tbody>
                                <tbody>
                                </tbody>
                             </div>   
                       </div>
                    </div>
                </div>    
               </div> 
                </td>
              

            </table>
            
            
            <br />
            <br />
            <?php
if($cabeza[0]['tipo'] == "Empleado")
{
	$text1= "<div style='text-align:center;'><h4> Texto para empleado</h4></div>";
}
else{
  $text1= "<div style='text-align:center;'><h4> Texto para proveedor</h4></div>
  ";
}

echo $text1;

?>    

  <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 align="center"><strong>Motivo del rechazo</strong></h5>
        <button type="button" class="close" data-dismiss="modal" >
          
        </button>
      </div>
      <div class="modal-body">
          
        <textarea  cols="40" rows="3" id="textore"></textarea><br>
        
      </div>
      <div class="modal-footer">
          
          <button type="button" class="btn btn-success" data-dismiss="modal" onclick="rechazarAnticipo(<?php echo $cabeza[0]['consecutivo']; ?>, $('#textore').val())">Enviar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

          
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        
                    
                    </div>
                    <?php 
        $userids = $detalle[0]['userid'];
        
        
        
        
        ?>
                    </tr>
                    </table>
                <div align="center">
                   <?php 			   
                    if($cabeza[0]['estado'] == '1'){ 
                    $moneda = $cabeza[0]['moneda'];
             
                     $sqs = "SELECT monto_autorizado FROM matrizAnticipos WHERE tipo_moneda = '$moneda'";
                     $querys = mysqli_query($mysqli, $sqs);
                     while($rows = mysqli_fetch_array($querys))
                     {
                         $montoAutorizado = $rows['monto_autorizado'];
                     }
                    
                     
                    ?> 
                    </div>
      

                    <?php
                    if ($cabeza[0]['confirmacionCompras'] == 'true' && $cabeza[0]['confirmacionGerencia'] == '' &&  $cabeza[0]['monto'] > $montoAutorizado) 
                    
                    {
                    ?>
                  <h4 align="center">Documento en proceso <br> <?=$cabeza[0]['observacionP']?>  </h4> <?php
                
                
                   
                
                echo "<h5 align='center'>ANTICIPO CONFIRMADO POR COMPRAS! <br></h5>
                </div> 
                <div class='form-group' align='center'>
                <input type='checkbox' name='fancy-checkbox-danger-custom-icons' id='fancy-checkbox-danger-custom-icons' autocomplete='off' required  onCLick='checkCompras()' />
                <div class='btn-group'>
                    <label for='fancy-checkbox-danger-custom-icons' class='btn btn-success'>
                        <span class='glyphicon glyphicon-remove'></span>
                        <span class='glyphicon glyphicon-ok'></span>
                    </label>
                    
                </div>
                <button type='button' class='btn btn-danger' style='color: white;' data-toggle='modal' data-target='#exampleModalCenter'><span class='glyphicon glyphicon-remove'></span>    </button>
            </div>          
                ";
                
                  
                echo "
                
              <div class='col-md-5' >
                
              </div>                 
            
              
                <div class='col-md-3' >               
                <input type='text' value=' $parametro' id='consecutivo' hidden>   
                <input type='button' class='btn btn-success'  id='boton' value='Enviar confirmación.' onclick='validacion()' style='background-color:#00965e; color:white;'>
               
                      
    
              
              ";
               
              
                      
            }
            ?>
            
                    <div align="center">
                    <div align="center">
                    <?php }
                    
            
                    
                    if($cabeza[0]['estado'] == 'REC'){ ?> 
                      </div>
                      <div class='alert alert-danger'><h4 align="center">Anticipo rechazado.</h4></div>
                      <br> <?=$cabeza[0]['observacionP']?>  
                      <div align="center">
                      <?php }  ?>
                      <?php  
                      
                      if($cabeza[0]['estado'] == 'APR'){ ?> 
                      </div>
                      <div class='alert alert-success'><h4 align="center">Anticipo aprobado.</h4></div>
                      <br> <?=$cabeza[0]['observacionP']?> 
                      <div align="center">
                      <?php }  ?>
                      <?php  
                      
                      if($cabeza[0]['estado'] == 'APRC'){ ?> 
                      </div>
                      
                      <div class='alert alert-success'><h4 align="center">Anticipo aprobado por contabilidad.</h4></div>
                      <br> <?=$cabeza[0]['observacionP']?>
                      <div align="center">
                      <?php }  ?>
                      <?php  
                      
                      if($cabeza[0]['estado'] == 'RECC'){ ?> 
                      </div>
                      <div class='alert alert-danger'><h4 align="center">Anticipo rechazado por contabilidad.</h4></div>
                      <br> <?=$cabeza[0]['observacionP']?>  
                      <div align="center">
                      <?php }  ?>
                      <?php  
                      
                      if($cabeza[0]['estado'] == '1' && $cabeza[0]['confirmacionCompras'] == '' )
                      { 
                  
                        ?> 
                      </div>
                      <div class='alert alert-warning'><h4 align="center">Anticipo en proceso.</h4></div>
                      <br> <?=$cabeza[0]['observacionP']?>
                      
                        <div class='col-md-3'></div>
                        <div class='col-md-6'>
                        <div class='alert alert-danger'><h4 align="center">ANTICIPO NO CONFIRMADO POR COMPRAS!</h4></div>
                        
                        
                        </div>                 
                        <div class='col-md-3'></div>
            
                  
                  

                      <?php 
                        }  
                      ?>
                       <?php  
                      
                      if($cabeza[0]['estado'] == '1' && $cabeza[0]['confirmacionCompras'] == 'true' && $cabeza[0]['confirmacionGerencia'] == 'true'){ 
                      
                      echo "<div class='alert alert-warning'><h4>Anticipo en Aprobador</h4></div>";
                      
                       }  ?>
                      
                      
                      
                    <p>&nbsp;</p>
                    <p>
                    <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
                    <input name="rcid" type="hidden" id="rcid" value="<?=$_REQUEST['id']?>" />
                    </p>
                    
                    </form>           
                </div>
                
              
        </div>                  
        </div>
        </div>         
           
              
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

      <script>
      $(document).ready(function(){
        checkCompras();
        
      });
      function checkCompras() {
        let boton = $('#fancy-checkbox-danger-custom-icons').prop('checked');
        
        if (boton == true) {
          
          document.getElementById("boton").disabled = false;
          
        } else
        {

          document.getElementById("boton").disabled = true;
        }
        
      }
      function actualizar(){location.reload(true);}


      function validacion()
      {
        let boton = $('#fancy-checkbox-danger-custom-icons').prop('checked');
        let consecutivo = $('#consecutivo').val();
        if(boton == true)
        {
          $.ajax ({

        url : 'postGerencia.php',
        data: {boton, consecutivo},
        type: 'POST',
        success : function(response){
          if(response == "si")
          {
            swal ( "Anticipo Confirmado" ,  "Anticipo confirmado exitosamente" ,  "success");
            setInterval("actualizar()",1000);
          }
          else
          {
            swal ( "Anticipo no confirmado" ,  "Anticipo no confirmado" ,  "error");
          } 
        }

          });
        }
        
        
      }
        
        
      function rechazarAnticipo(id, descripcion)
      {
          
          $.ajax({
          url:'rechazarAnticipoGerencia.php',
          type:'POST',
          data:{id, descripcion},
          success:function(response)
          {
              if(response == "Actualizado ")
              {
                  swal ( "Rechazo anticipo" ,  "Se rechazo el anticipo correctamente." ,  "success").then();
                  swal("Rechazo anticipo", {
								icon: "success",
								}).then((success)=>{
									window.location = 'https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/Listados/Gerencia/index.php?op=Gerencia';
								});
                  
              }
              else
              {
                  swal ( "Rechazo anticipo" ,  "Anticipo no rechazado" ,  "error");
              }
          }
          
          });
      }    
      </script>


<?php require_once('../../pie.php'); }?>

		
				
