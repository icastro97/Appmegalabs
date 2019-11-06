<?php 

require_once("../../seguridad/config.php");
$parametro = $_POST['id'];
$status = FALSE;


require_once("../../seguridad/arraypermiso.php");
unset($_SESSION['uId']);

//start session
//session_start();

//get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
$sesion = $_SESSION["user_id"];

?>
<?php
if (isset($_POST['id'])) {
	$sid = $_POST['id'];  		
}


//load and initialize database class
require_once '../../mcv5/clases/DB.class.php';
$db = new DB();

//get users from database
$conditionsempresa['where'] = array('id '=> 1,); 
$empresa = $db->getRows('empresa',$conditionsempresa); //ojo se pone tabla a consultar


$bancos = $db->getRows('bancos',array('order_by'=>'descripcion ')); //ojo se pone tabla a consultar

$conditions['where'] = array('id_cabeza'=> $sid,); 
$users = $db->getRows('lg_cabeza',$conditions); //ojo se pone tabla a consultar


//detalle recibo
$conditionsdetalle['where'] = array('id'=> $sid,); 
$detalle = $db->getRows('lg_det_cabeza',$conditionsdetalle); //ojo se pone tabla a consultar


$sql20= "select a.factura,a.nit ,a.fichero as name, a.tipo as type, a.id as legalizacion, b.ico from lg_det_cabeza a inner join rc_mime b on a.tipo = b.type where a.id =   " . $sid;
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


<?php  require_once('../../cabeza.php'); 


if(!isset($_SESSION["session_username"])) {	
  header("location:../../logininicial.php");
} 
else {?>
<!---->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../formulario1/bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src="../formulario1/js/jquery.min.js"></script>
<script src="../formulario1/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="assets/popcalendar.js"></script>
<script type="text/javascript" src="assets/ajax.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
    



  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


<script src="../../datatables/jquery.dataTables.js"></script>
<script src="../../datatables/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="../../datatables/dataTables.bootstrap.css">

<script src="assets/jquery.maskMoney.js" type="text/javascript"></script>


<style type="text/css">
.container{padding: 8px; }
table tr th, table tr td{font-size: 1.2rem;}

.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right;}
a.glyphicon{text-decoration: none;}
a.glyphicon-trash{margin-left: 10px;}
.panel > .panel-heading {
    background-image: none;
    background-color: #00AB84;
	color: white;
}
</style>



   		
                <?php 
               
               $ident = $detalle[0]['identificador'];
                 $lg = $users[0]['id_cabeza'];
                 $tipos = $users[0]['tipolegalizacion']; 
                 $fecha = $users[0]['fecha']; 
                 $identificacion = $users[0]['identificacion']; 
                 $nombre = $users[0]['nombre']; 
                 $cargo = $users[0]['cargo']; 
                 $ctocto = $users[0]['ctocto']; 
                 $linea = $users[0]['linea']; 
                 $area = $users[0]['area'];                                   
                 $aprobador = $users[0]['aprobador']; 
                 $observaciones = $users[0]['observaciones']; 
                 $userid = $users[0]['userid'];
                 
                 
                 
                $ms= "UPDATE lg_cabeza SET boton = '0' where id_cabeza = ".$lg;
                $result = mysqli_query($mysqli, $ms);
                 
                 $sql = "INSERT INTO lg_cabeza (tipolegalizacion,valoranticipo,fecha,identificacion,nombre,cargo,ctocto,linea,area,userid, observaciones,estado, aprobador, lganterior, boton) VALUES ('$tipos','0','$fecha', '$identificacion', '$nombre','$cargo', '$ctocto', '$linea', '$area','$userid','$observaciones', '0','$aprobador', '$lg', '1')";
                 $query = mysqli_query($mysqli, $sql);	
                 echo $sql."<br>";
                 
                 $consecutivo = mysqli_insert_id($mysqli);
              
                                    
                                    
                                    
                ?>
	      	    

                <td><div id="resultadotemporal">

						 
								<tbody id="userData2">
									<?php $sumaneto = 0;
									if(!empty($detalle)): $count = 0; foreach($detalle as $user): $count++; ?>
									
									<?php
									 
									 $ide = $user['identificador'];
									 $fecfact = $user['fecfact'];										
									 $factura = $user['factura'];										
									 $nit = $user['nit'];										
									 $establecimiento = $user['establecimiento']; 
                                     $ciudad = $user['ciudad']; 
                                     $cinversion = $user['cinversion']; 
                                     $tgasto = $user['tipogasto'];
                                     $concepto = $user['concepto'];
                                     $descripcion = $user['descripcion'];                                     
								     $moneda = $user['moneda'];
                                     $valor = $user['valor']; 
                                     $fichero = $user['fichero'];
                                     $tipor = $user['tipo'];
                                     $asis = $user['asistencia'];
                                     $tipoCode = $user['tipoCodigo'];
                                     
                                     
                                     
                                     $sqli="INSERT INTO `lg_det_cabeza`(`identificador`, `id`, `fecfact`, `factura`, `nit`, `establecimiento`, `ciudad`, `cinversion`, `tipogasto`, `concepto`, `descripcion`, `moneda`, `valor`, `fichero`, `tipo`, asistencia, tipoCodigo)
                                     VALUES( null, $consecutivo, '$fecfact' , '$factura' ,'$nit' , '$establecimiento' , '$ciudad', '$cinversion','$tgasto','$concepto','$descripcion','$moneda', '$valor', '$fichero', '$tipor', '$asis', '$tipoCode')";
                                     echo $sqli."<br>";
                                     $ejecutar = mysqli_query($mysqli, $sqli);	  
                                                
                                   $identificador = mysqli_insert_id($mysqli);
                                    
                     
                                    
                                    header("Location:https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/index2.php?documento=$consecutivo&op=LISTADO%20LEGALIZACIONES");
                                   
                                    
                    
                                      
                                     ?>
                                    
                                    <?php
                                    $consulta = "SELECT * FROM asistencia where identificadorlg = '$lg' and identificadordet = '$ide'";
                                    echo $consulta."<br>";
                                    $ejecu = mysqli_query($mysqli, $consulta);
                                    $numero = mysqli_num_rows($ejecu);
                                    foreach($ejecu as $row)
                                    {
                                        $tipe = $row['tipo'];
                                        $cantidad = $row['cantidad'];
                                        $nombreAsistente = $row['nombreAsistente'];
                                        $cedulaAsistente = $row['cedulaAsistente'];
                                     
                                   
                                        $script = "INSERT INTO asistencia (tipo,cantidad, nombreAsistente, cedulaAsistente, identificadorlg, identificadordet) VALUES ('$tipe', '$cantidad', '$nombreAsistente','$cedulaAsistente', '$consecutivo','$identificador')";
                                        echo $script."<br>";
                                        $ejecucionScript = mysqli_query($mysqli, $script);
                                    
                                        header("Location:https://appmegalabs.com/scandinavia/aplicaciones/legalizaciones/index2.php?documento=$consecutivo&op=LISTADO%20LEGALIZACIONES");
                                    }
                                    
                                    ?>
                                        
    
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
</div>
</div>                 

                  

<?php require_once('../../pie.php'); }?>



		
				
