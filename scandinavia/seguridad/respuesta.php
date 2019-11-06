<?php  require_once('cabeza.php'); ?>



<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>


<script type="text/javascript" src="assets/ajax.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">



<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
          

<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}

.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}


.form
{
    width:80%;
    margin-left:130px;
}

.btn
{
    
    background-color:#337ab7;
    color:white;
}

.area
{
    margin-left:80px;
}
@media screen and (max-width: 800px) 
{
    .form
    {
        width:100%;
        margin-left:0px;
    }
    .btn
    {
        margin-left:100px;
        background-color:#337ab7;
        color:white;
    }
    .area, .area1
    {
        margin-left:0px;
        width:100%;
    }
}


@media screen and (max-width: 600px) 
{
    .form
    { 
        width:100%;
        margin-left:0px;
      
    }
    .s
    {
        margin-left:100px;
        background-color:#337ab7;
        color:white;
    }
    
    .area, .area1
    {
        margin-left:0px;
        width:100%;
    }
    .text 
    {
        margin-left:20px;
    }
}



</style>




<script type='text/javascript'>
$(function(){   

$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);

	$('#dateArrival1').datepicker({
		dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '0d'
});
});
		
				
						
</script>
                       
<div class="container">
    
    <div class="alert alert-success" role="alert">
      Se envío la información correctamente!
    </div>
    <table width="100%" border="0">
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <img src="logobig.png">
            	    <td colspan="3" align="center"><h3>Canal etico de denuncias confidencial anónimo</h3></td>
            	    </tr>
            	  <tr>
            	    <td colspan="2" align="center">&nbsp;</td>
            	    <td colspan="4" align="right">&nbsp;</td>
            	    <td align="center" valign="top">&nbsp;</td>
            	  </tr>        
            	  </table>	
            	
    <!--<form id="my-form" method="post" action="guardar.php?inserted=1" name="insertregistro" enctype="multipart/form-data">-->
   <div class="panel panel-primary">
            <div class="panel-heading text-center form-control" >Formulario de denuncia</div>
             
               <form class="form" method="post" action="formulario2.php" enctype="multipart/form-data">
                
                        
            	
               
                    <div class="panel-body"> 
                            <?php
                            date_default_timezone_set('America/Bogota');
                            $fechaActual=date("d-m-Y");
                            ?>
                            <br>
                            <div class="row">
                                                             <div class="col-md-1"></div>

                                                            <div class="col-md-3">
                                                                <label for="ex2">Titulo Reporte Confidencial</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <input name="titulo"  id="titulo" type="text"  style="text-transform:uppercase" class="form-control" placeholder="Titulo Reporte Confidencial" disabled/>
                                                            </div>
                                                           
                            </div>
                            <br>
                            <div class="row">
                            
                                                            <div class="col-md-1"></div>

                                                            <div class="col-md-3">
                                                            <label for="ex2">Fecha del Reporte</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <input class="form-control" type="datetime" name="fechaActual" id="fecha"  value="<?= $fechaActual?>" disabled/> 
                                                            </div>
                            </div>
                             <br>                      
                            <div class="row">
                            
                                                            <div class="col-md-1"></div>

                                                            <div class="col-md-3">
                                                            <label for="ex2">Fecha en que Sucedió el Evento</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <input type="text" class="form-control" name="fechasiguiente" id="dateArrival1" placeholder="Seleccionar Fecha" disabled>
                                                            </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-9">
                                <h5>A la hora de documentar su evento, puede utilizar las siguientes pautas para mayor claridad en su comunicado: </h5>
                                <ul>
                                <li>(¿Quién?)</li>
                                <li>(¿Qué?)</li>
                                <li>(¿Dónde?)</li>
                                <li>(¿Cuándo?)</li>
                                <li>(¿Por qué?)</li>
                                <li>(¿Cómo?)</li>
                                </ul>
                                </div>
                             </div>   
                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="text">Descripción General del Evento: </h5>
                                        <div class="col-md-3">
                                            <textarea class="area1" name="descripcion" id="" cols="80" rows="4" disabled></textarea>
                                        </div>                            
                                    </div>

                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="text">Otros Comentarios: </h5>
                                        <div class="col-md-3">
                                            <textarea class="area" name="comentario" id="" cols="80" rows="4" disabled></textarea>
                                        </div>                            
                                    </div>
                                    <br>
                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="text">Datos adjuntos: </h5>
                                    <div class="col-md-2"></div>                                    
                                        <div class="col-md-3">
                                            <input type="file" name="file"disabled>
                                        </div>
                                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-3">
                            <input name="enviar" type="submit" id="enviar"  class="btn" value="Enviar Información" disabled /> 
                        </div>
                    </div> 
                      </form> 
                      <br>
         
     </div>                   
</div>                  
               
<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        2019 - HBT
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->
      

<?php require_once('../pie.php'); ?>



		
				

		
