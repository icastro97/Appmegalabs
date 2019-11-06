<?php 

require_once("../../seguridad/config.php");
$parametro = $_REQUEST['id'];
$status = FALSE;

require_once("../../seguridad/arraypermiso.php");

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$parametro = $_REQUEST['id'];

echo $parametro;

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
$conditionscabeza['where'] = array('id_anticipo'=> $parametro,); 
$cabeza = $db->getRows('anticipo',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$detalle = $db->getRows('anticipo',$conditionsdetalle); //ojo se pone tabla a consultar

//totales por moneda
$conditionstotales['where'] = array('consecutivo'=> $cabeza[0]['consecutivo'],); 
$totalesdetalle = $db->getRows('vw_talAnticipo2',$conditionstotales); //ojo se pone tabla a consultar



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

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 

<style type="text/css">
.container{padding: 10px;}
table tr th, table tr td{font-size: 1.2rem; }
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.formato{font-size:96%;}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
    

                  
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
    <div class="panel panel-primary">
    <div class="panel-heading text-center form-control" >Información General</div>
	<table width="100%" border="0"> 
  
	  <tr>	    
	    <td class="formato" colspan="5" align="center"><strong>Tipo:</strong> <?php echo $cabeza[0]['tipo']; ?></td><td >&nbsp;</td> <td class="formato" colspan="5" align="left"><strong>Identificación: </strong><?php echo $cabeza[0]['identificacion']; ?></td> 
      <td class="formato" colspan="6" ></td>
     
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
                <th rowspan="3" align="center" ><div align="center">Identificación</div></th>
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
                if($user['tipo'] == "Empleado")
                    {
                      
                        if($user['pdf'] == null)
                        {
                          ?>
                            <td align="right"> </td>
                          <?php
                        }          
                        else
                        {?>
                          <td align="center">
                            <?php 
                              echo "<a href=\"" . $user['pdf'] . " \"target=\"\_blank\">";
                              echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' alt=\"".$row_Obser['pdf']."\" width=\"30\" height=\"30\" />"; ?>
                          </td> 
                          <?php
                        }   
                        
                        ?>
                    <?php
                    }
                    else
                    {
                      if($user['archivo'])
                      {
                          ?>
                          <td align="center"><?php echo "<a href=\"uploads/" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/" .$row_Obser['ico']. "\" alt=\"" . $row_Obser['archivo']. "\" width=\"20\" height=\"20\" />"; ?></td>  
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
              <tr>
                <td width="21%">Descripción:</td>
                <td width="39%">
                <textarea  name="txtobservaciones" rows="5" class="form-control mb-2 mr-sm-2 mb-sm-0" id="txtobservaciones" readonly><?=$cabeza[0]['descripcion']?> </textarea></td>
                <td width="20%" align="right">Total:</td>
                <td width="20%">		<table class="table table-striped">
            <tbody id="userData2">
              <tr></tr>
            </tbody>
            <thead>
              <tr>
                <th rowspan="3"></th>
                <th rowspan="3" valign="bottom"><div align="center">Moneda</div></th>
                <th rowspan="3" valign="bottom"><div align="center">Valor</div></th>
                
              </tr>
              <tr></tr>
            </thead>
            <tbody id="userData5">
              <?php $sumavalores = 0; $arraymonedas = "";
					if(!empty($totalesdetalle)): $countyer = 0; foreach($totalesdetalle as $usertotdetalle): $countyer++; ?>
              <tr>
              <td>&nbsp;</td>    
              
                <td align="center"><?php echo $usertotdetalle['moneda']; ?></td>
                <td align="right">
                  $<?=number_format(($usertotdetalle['sumas']), 2)?></td>                                                
              </tr>
              <?php 
			  $arraymonedas = $arraymonedas . ", " . $usertotdetalle['moneda'] . "$" . number_format(($usertotdetalle['sumas']), 2);
			  endforeach; else: ?>
              <tr>
                <td colspan="5">No existen valores para mostrar......</td>
              </tr>
              <?php endif; ?>
            </tbody>
            <tbody>
            </tbody>
        </table>  
                </td>
              </tr>

            </table>
            
            
            <br />
            <br />
            <?php
if($cabeza[0]['tipo'] == "Empleado")
{
	$text1= "<div style='text-align:justify;'> Texto para empleado</div>";
}
else{
	$text1= "<div style='text-align:justify;'> Texto para proveedor</div>";
}

echo $text1;

?>    



            
            <p>&nbsp;</p>
            <p>&nbsp;</p>
             <?php if($cabeza[0]['estado'] == '1'){?> 
            <table width="70%" border="0" class="table table-striped">
              <tr>
                <td align="right">&nbsp;</td>
                <td><h4>Observaciones </h4></td>
              </tr>
              <tr>
                <td width="23%" align="right"><h5>Estado:</h5></td>
                <td><label for="estadoscartera"></label>
            
                  <select  name="estadoscartera" id="estadoscartera" class="form-control form-control-lg" onchange="habilitartxt(this.value);"> 
                    <option value="APR">APROBADO</option>
                    <option value="REC">RECHAZADO</option>
                  </select></td>
              </tr>
              <tr>
                <td><input name="pasaguid" type="hidden" id="pasaguid" value="<?=$consultaguid?>" /></td>
                <td><textarea name="ObservacionP" cols="40" rows="3" id="ObservacionP" class="form-control form-control-lg" placeholder="Descripcion"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Aprobar" id="Aprobar" value="Procesar" class="btn btn-primary" /></td>
              </tr>
            </table>
           <div align="center">
               <?php } else 
			   { 			   
			   if($cabeza[0]['estado'] == 'APR'){ ?> 
            </div>
            <h4 align="center">Documento Aprobado</h4> 
            <div align="center">
              <?php } 
			  
			  if($cabeza[0]['estado'] == 'REC'){ ?> 
            </div>
            <h4 align="center">Documento Rechazado <br> <?=$cabeza[0]['observacionP']?>  </h4> 
            <div align="center">
              <?php }  
			  
			  
			  } ?>
            </div>
            <p>&nbsp;</p>
            <p>
            <input type="hidden" name="OP" id="OP" value="<?=$_REQUEST['op']?>">
            <input name="rcid" type="text" id="rcid" value="<?=$_REQUEST['id']?>" />
            </p>
            
            </form>           
        </div>
</div>
</div>                  
</div></div>         
                  
              
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

		
				
