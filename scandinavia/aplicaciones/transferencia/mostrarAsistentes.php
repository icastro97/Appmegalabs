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


    $condition['where'] = array('identificadordet'=> $sid,); 
    $detalle = $db->getRows('asistencia_trans_valor',$condition);
    
    $sql ="SELECT DISTINCT  T1.id_asistenciaTrans as id_asistenciaTrans, `tipo`,`cantidad`, `nombreAsistente`, `cedulaAsistente`, `identificadordet`, valor, T2.transferenciaValor as consentimiento FROM asistencia_trans_valor T1 LEFT JOIN resultadoCruce T2 ON T2.cedula = cedulaAsistente WHERE identificadordet = '$sid'";
    $resultado = mysqli_query($mysqli, $sql);
   
    
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
         
          <a  href="https://appmegalabs.com/scandinavia/aplicaciones/transferencia/deTransferencia.php?documento=<?=$sid?>" class="glyphicon glyphicon-circle-arrow-left"  style="color:#337ab7;cursor:pointer;"></a> Regresar 
         <br>
    <div class="row">
         <div class="col-md-6">
            <h1 align='center'>Detalle de asistentes</h1> 
            <table class="table ">
    <tr>
        <th>ID</th>
        <th>TIPO</th>
        <th>CANTIDAD</th>
        <th>NOMBRE ASISTENTE</th>
        <th>CEDULA ASISTENTE</th>
        <th>VALOR</th>
        <th>ELIMINAR</th>
        <th>CONSENTIMIENTO</th>
        
    </tr>
        <?php
        foreach( $resultado as $user)
        {
    
        ?> 
           <tr>
                <td><?= $user['id_asistenciaTrans']?></td>
                <td><?= $user['tipo']?></td>
                <td><?= $user['cantidad']?></td>
                <td><?= eliminar_tildes($user['nombreAsistente']);?></td>
                <td><?= $user['cedulaAsistente']?></td>
                
                <td>$<?= $user['valor']?></td>
               
                <td><button class='btn btn-danger' onclick='eliminarAsistentes(<?=$user['id_asistenciaTrans'];?>, <?=$user['identificadordet'];?>)'><i class='glyphicon glyphicon-trash'></i></button></td>
                <?php
                $consentimiento = $user["consentimiento"];
                if(!empty($consentimiento))
                {
                
                echo "<td>Si cuenta con consentimiento</td>";
                }
                else
                {
                echo "<td>No cuenta con consentimiento</td>";
                }
                ?>

           </tr>
        <?php
        }
        
        ?>
    </table>
        </div>
        <div class="col-md-6">
         
        <?php
         $cc = "SELECT id_archivo, nombreArchivo, ruta_Archivo, tipo_archivo FROM archivos_facturas where id_factura = ".$sid;
         //var_dump($cc);
         $resultado = mysqli_query($mysqli, $cc);
         
        ?>
        <h1 align='center'>Documentos</h1> 
        <table class="table" >
        <tr>
            <th align="center"><center>Nombre</center></th>
            <th align="center"><center>Documento</center></th>
            <th align="center"><center>Eliminar</center></th>
            
        </tr>
          <?php
        while($row = mysqli_fetch_assoc($resultado))
            {
          ?>
        <tr>
            
        <?php
           echo "<td align='center'>".$row['nombreArchivo']."</td>"; 
           
											if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_word.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "image/png")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_png.png' width='20' height='20' /></a></td>"; 
												
											}  
											else if ($row['tipo_archivo'] == "application/pdf")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_pdf.png' width='20' height='20' /></a></td>";                   
											}
											else if($row['tipo_archivo'] == "image/jpg" || $row['tipo_archivo'] == "image/jpeg")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_jpg.png' width='20' height='20' /></a></td>"; 
											}	
											else if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
											{
												echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_powerpoint.png' width='20' height='20' /></a></td>"; 
											}
											else if($row['tipo_archivo'] == "application/vnd.ms-excel")
											{
													echo "<td align='center'> <a href='".$row['ruta_Archivo']."' target='_blank'>";
												echo "<img src='/scandinavia/assets/images/ico/ico_excel.png' width='20' height='20' /></a></td>";
											}
											
											
           
            echo "";
            ?>
            <td align='center'><button class='btn btn-danger' onclick='eliminarImagen(<?php echo $row['id_archivo'] ?>)'><i class='glyphicon glyphicon-trash'></i></button></td>
            </tr>
            
            <?php
                }
                ?>
            </table>
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

<script>
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

</script>
<?php require_once('../../pie.php'); }?>

