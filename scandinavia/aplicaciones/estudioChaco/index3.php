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
$conditionscabeza['where'] = array('id_formularioc'=> $parametro,); 
$cabeza = $db->getRows('formulariochaco',$conditionscabeza); //ojo se pone tabla a consultar

//detalle recibo
$conditionsdetalle['where'] = array('id_formularioc'=> $cabeza[0]['id_formularioc'],); 
$detalle = $db->getRows('formulariochaco',$conditionsdetalle); //ojo se pone tabla a consultar




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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

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
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}
</style>


 <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
    

<a href="https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/listadoAnticipos.php?op=Listado%20Anticipos" class="glyphicon glyphicon-circle-arrow-left" ></a> Regresar 
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


<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}

.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}


.texto 
{
    margin-top:4px;
    margin-left:2px;
    color:black;
}

@media screen and (max-width: 800px) 
{
    .texto
    {
        margin-top:4px;
    }
    
}


@media screen and (max-width: 600px) 
{
    .texto
    {
        margin-left:30px;
        margin-top:-20px;
        
    }
    
}

.panel > .panel-heading {
    background-image: none;
    background-color: #337ab7;
    color: white;
}

.titulo
{
    margin-left:480px;
    margin-top:-15px;
    font-size: 20px;
}

.antro
{
    margin-left:-50px;
}
.titulo1
{
    margin-left:50px;
}
.titulo2
{
    margin-left:50px;
}
.titulos 
{
    margin-right:250px;
}
.confidencial
{
    margin-left:100px;
}
.antro1
{
    margin-left:-50px;
    margin-top:47px;
}
</style>
<div class="alert alert-success" role="alert">
  <h4>Diligenciamiento y envio exitoso!</h4>
</div>
    <table width="100%" border="0">
        
                    <tr>

                    <td colspan="2" align="center" valign="top"><img src="/scandinavia/assets/img/logobig.png" alt="" width="186" height="117"  /></td>
                    <td colspan="2" align="center"><h3 class="titulos"><strong>CRF</strong></h3></td>
                    </tr>
            	  <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                    
            	    <td colspan="2" align="center"><h3 class="titulos"><strong>Formato ELECTRÓNICO de Recolección de Datos</strong></h3></td>
            	    </tr>
            	  <tr>
                      <tr>
                      <td colspan="3" align="center"><h3 ><strong>Estudio CHACO – 2018 - V01 </strong></h3></td> 
                      
                      </tr>
                         
                      <tr>
                          <td colspan="3" align="center"><h4>“Estudio <strong>CHACO</strong>: <strong>C</strong>ontrol de la <strong>H</strong>ipertensión <strong>A</strong>rterial en pacientes <strong>CO</strong>lombianos” </h4></td> 
                      
                      </tr>
                      <tr >
                    <td colspan="3" align="center"><h3><strong>AVISO DE CONFIDENCIALIDAD </strong></h3></td>     
                       
                      
                    
                      </tr>
                      
                      
                       </tr>
                      
                      <?php if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
                                                
                                                <?php endforeach; else: ?>
              <tr>
                
              </tr>
              <?php endif; 
			  
			  
			  ?>
                     
                      
                     
                  </tr> 
                      
    </table>
    <div class="row"></div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <h6 class="confidencial" align="justify">La información contenida en este documento es propiedad de SCANDINAVIA PHARMA LTDA, salvo que se haya concertado por escrito otro tipo de acuerdo. Al aceptar o revisar este documento, queda usted obligado a respetar su CARÁCTER CONFIDENCIAL, a no revelar esta información a terceros (salvo que la Legislación vigente así lo exija) y a no utilizarla para fines distintos de los autorizados. Si se produce o se sospecha un incumplimiento de esta obligación, debe informarse al DEPARTAMENTO MÉDICO de SCANDINAVIA PHARMA LTDA lo antes posible.</h6>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row"></div>
<?php
    date_default_timezone_set('America/Bogota');
    $fechaActual=date("d-m-Y");
?>       
    
<?php

?>
<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-3">
        <label for="ex2">Fecha Actual</label>
        <h6><?=$user['fechaActual']?><h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Nombre Médico</label>
    <h6><?=$user['nombreMedico']?><h6>
    </div>
    <div class="col-md-3">
    <label for="ex2">Ciudad</label>
    <h6><?=$user['ciudad']?><h6>
    </div>
    <div class="col-md-2">
    <label for="ex2">Codigo Paciente</label>
    <h6 style="color:red;"><?=$user['codigoPaciente']?><h6>
    </div>

</div>
<br>


<form name="formulario" action="index2.php" method="post"  enctype="multipart/form-data">
    <div class="panel" style="border:1px solid #337ab7;" >
                                   <div class="panel-heading text-center form-control" >Datos Inclusión y Exclusión</div>
                <input type="hidden" name="fechaActual" value="<?php echo date("d/m/Y");?>">                                   
                <input type="hidden" name="nombreMedico" value="<?= $users[0]['full_name'];?>">
                <input type="hidden" name="ciudad" value="Bogota D.C.">
                <input type="hidden" name="codigoPaciente" value="01">
                <input type="hidden" name="estudio" value="CHACO">
                                            <div class="panel-body" > 
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body" >
                                                            <h5 ><strong>Criterios de inclusión</strong></h5>                                                         
                                                            <p class="card-text">
                                                            <ul>
                                                             <li value="1"><h6>Edad mayor o igual a 18 años. </h6></li>
                                                             <li value="2"><h6>Diagnóstico PREVIO de Hipertensión Arterial:  Diagnóstico realizado ≥ 3 meses antes.</h6></li>
                                                             <li value="2"><h6>Pacientes que se encuentren bajo tratamiento farmacológico de la HTA ≥ 3 meses antes.</h6></li>
                                                             <h5><strong>¿Cumple el paciente con los anteriores criterios de inclusión?</strong></h5>
                                                            </ul>
                                                            <br>
                                                            <div class="col-md-1"></div>                                                            
                                                            <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['siI']?></h6>                                                          
                                                            </div>    
                                                            
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                            <h6 class="texto"><?=$user['noI']?></h6>                                                                   
                                                            </div>    
                                                            
                                                            </p>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                        <div class="card-body">
                                                            <h5><strong>Criterios de exclusión</strong></h5>
                                                            <p class="card-text">


                                                            <ul>
                                                             <li value="1"><h6>El paciente HA RECHAZADO la participación en el estudio. </h6></li>
                                                             <li value="2"><h6>Pacientes quienes a juicio del Investigador no comprendan o no estén dispuestos a contestar adecuadamente las preguntas.</h6></li>
                                                             <li value="3"><h6>Enfermedad mental o psiquiátrica que a juicio del investigador impida una adecuada obtención de la información.</h6></li>
                                                             <h5><strong>¿Tiene el paciente alguno de los anteriores criterios de exclusión?</strong></h5>
                                                            </ul>
                                                            <br>
                                                            <div class="col-md-1"></div>                                                            
                                                            <div class="col-md-2">
                                                                <h5 class="texto"><?=$user['siE']?></h5>
                                                            </div>    
                                                            
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                
                                                                  <h5 class="texto"><?=$user['noE']?></h5>                                                                
                                                            </div>    
                                                             

                                                            </p>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>                          

                                                  
                                          
    </div>

    <div class="panel panel-primary">
                                <div class="panel-heading text-center form-control" >Historia clínica</div>
                                                
                                            <div class="panel-body"> 
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label class="titulo">Datos generales</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                                            <div class="col-md-1">
                                                                                <div class="form-group">
                                                                                                    
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-3 ">
                                                                                <div class="form-group">
                                                                                    <label for="ex2">Genero</label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                             <h6 class="texto"><?=$user['fem']?></h6>
                                                                                        </div>
                                                                                       
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                            <h6 class="texto"><?=$user['mas']?></h6>
                                                                                        </div>
                                                                                        
                                                                                    </div>                                                                                
 
                                                                                    
                                                                                </div>
                                                                            </div>    
                                                                            
                                                                            <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="ex2" class="titulo1">Antropométricos</label>                                                                                                                         			    			        
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <h6 class="antro"> Peso <strong> (KILOS)</strong></h6>   
                                                                                                <h6 class="antro1">Talla <strong> (CENTÍMETROS)</strong></h6>   
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                <input name="peso"   type="number" required="required" class="form-control" id="peso" min="20" max="300" value="<?=$user['peso']?>"  minlength="3" disabled />
                                                                                                <br>
                                                                                                <input name="talla"   type="number" required="required" class="form-control" id="talla"  min="100" max="300" value="<?=$user['talla']?>"  minlength="3" disabled/>
                                                                                                </div>  
                                                                                
                                                                            </div>

                                                                           

                                                                        
                                                                            <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="ex2" class="titulo2">Signos vitales</label>                                                                                                                         			    			        
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <h6 class="antro">P.A.Sistólica<br><strong>(mmHg)</strong></h6>   
                                                                                                
                                                                                                <h6 class="antro">P.A.Diastólica<br><strong>(mmHg)</strong></h6>   
                                                                                                </div>
                                                                                                <div class="col-md-5">
                                                                                                <input name="sistolica"   type="number" required="required" class="form-control" id="sistolica"  min="40" max="250" value="<?=$user['sistolica']?>"  minlength="3" disabled/>
                                                                                                <input name="diastolica"   type="number" required="required" class="form-control" id="diastolica" min="40" max="250" value="<?=$user['diastolica']?>"  minlength="3" disabled/>
                                                                                                </div>  
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                </div>                                                            
                                               <br>                         
                                                                                
                                            </div>                          

                                            
                                          
    </div>           
    <div class="panel panel-primary">
                                <div class="panel-heading text-center form-control" >Otros hallazgos</div>
                                                
                                            <div class="panel-body"> 
                                                
                                                <div class="row">
                                                 
                                                    <div class="col-md-12">
                                                     <ul>
                                                         <li >VALORES DE ÚLTIMOS PARACLÍNICOS (<font color="blue">Favor registrar SOLO los que haya disponibles.....</font><font color="red">EN CASO DE NO ESTAR DISPONIBLES,  COLOCAR  "NO"</font>):</li>
                                                     </ul>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4" >
                                                        <div class="form-group">
                                                                <label for="ex2">Colesterol Total(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['nocol']?></h6>    
                                                                        
                                                                    </div>
                                                                    
                                                             
                                                                 
                                                              
                                                                    <div class="col-md-2">
                                                                        
                                                                        <h6 class="texto"><?=$user['sicol']?></h6>
                                                                    </div>
                                                                    
                                                                    
                                                                <div class="col-md-2"  id="valor1">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor2"><?=$user['colesterol']?></div>
                                                                   
                                                                   
                                                              
                                                                  
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4" >
                                                    <div class="form-group">
                                                                <label for="ex2">Colesterol HDL(md/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['nocolh']?></h6>
                                                                    </div>
                                                            
                                                                
                                                                
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['sicolh']?></h6>
                                                                    </div>
                                                             
                                                                      <div class="col-md-2"  id="valor3">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor4"><?=$user['colesterolh']?></div>
                                                                   
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                        
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Triglicéridos (mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['notri']?></h6>
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['sitri']?></h6>
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor5">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor6"><?=$user['trigli']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                       
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Glicemia ayunas(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['nogli']?></h6>    
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['sigli']?></h6>    
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor7">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor8"><?=$user['gli']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>     
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Hemoglobina glicosilada(%)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['nohe']?></h6>    
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['sihe']?></h6>    
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor9">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor10"><?=$user['hemo']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Creatinina(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['nocre']?></h6>
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['sicre']?></h6>
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor11">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor12"><?=$user['cre']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div> 
                                                    
                                               </div>
                                               <div class="row">
                                                    <div class="col-md-12">
                                                    
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Ácido Urico(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['noac']?></h6>
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['siac']?></h6>
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor13">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor14"><?=$user['aci']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                        
                                                    </div> 
                                                    
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                                <label for="ex2">Albuminuria/Proteinuria(mg/dL)</label>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['noal']?></h6>
                                                                    </div>
                                                                    
                                                                
                                                               
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['sial']?></h6>    
                                                                    </div>
                                                                    
                                                                     <div class="col-md-2"  id="valor15">
                                                                     </div>
                                                                       <div class="col-md-3"  id="valor16"><?=$user['alb']?></div>
                                                                   
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div> 
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                    <ul>
                                                        <li value="-"><h5>¿Alguna OTRA ENFERMEDAD o FACTOR DE RIESGO que tenga el paciente  (DIFERENTE A LO CONTEMPLADO EN EL FORMATO <strong>CUESTIONARIO IMPRESO</strong>)?</h5></li>
                                                    </ul>
                                                    </div>            
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="texto"><?=$user['noH']?></h6>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                    <h6 class="texto"><?=$user['siH']?></h6>    
                                                                    </div>
                                                                    
                                                                </div>                                                                                
                                                                                    
                                                        </div>
                                                    </div>                                                        
                                                </div>  
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                <div class="col-md-6" id="info">
                                                   <?php
                                                   
                                                   $si = $user['siH'];
                                                    if($si == "Si")
                                                    {
                                                       ?>
                                                       <div class="col-md-9" id="info">
                                                         <label>Descripción:</label>
                                                               <br>
                                                           
                                                    </div>
                                                    
                                                           <div class="col-md-9" id="info2">
                                                            <?=$user['descripcion'];?>
                                                            </div>
                                                    <?php
                                                        
                                                    }
                                                    else
                                                    {
                                                        echo "No aplica";
                                                    }
                                                    ?>
                                                    
                                                </div>
                                                </div>                                                    
                                               <br>                         
                                                                                
                                            </div>                          

                                            
                                          
    </div>            
                                    
    </div>
<div class="col-md-3"></div>
<div class="col-md-1"></div>
<div class="col-md-1"></div>
<div class="col-md-3">
    <h4 style='text-decoration:none;color:black;'>Generar pdf</h4>
     <td><?php echo "<a href=\"" . $user['archivo'] . " \"target=\"\_blank\">";echo "<img src=\"/scandinavia/assets/images/ico/ico_pdf.png\" alt=\"" . $row_Obser['archivo']. "\" width=\"60\" height=\"60\" />"; ?></td>  
</div>     
                        
                  
                  

      

<?php require_once('../../pie.php'); }?>



		
                
            
                        
                  
                  

      




		
				



		
				