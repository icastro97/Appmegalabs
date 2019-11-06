<?php
require('conexion.php');
require('fpdf/fpdf.php');
require('montoescrito.php');
require ('phpmailer/class.phpmailer.php');

$cedula = $_REQUEST['identificacion'];
$imagen = $_REQUEST['imagen'];
$consecutivo = $_REQUEST['documento'];

$sql="SELECT * FROM anticipo WHERE consecutivo = ".$consecutivo;
$query =mysqli_query($bd, $sql);
while($row = mysqli_fetch_array($query))
{
    $fechaAnticipo = $row['fechaActual'];
    $identificacion = $row['identificacion'];
    $nombre = $row['nombre'];
    $descripcion = $row['descripcion'];
    $inicio = $row['fechaini'];
    $fin = $row['fechafin'];
    $moneda = $row['moneda'];
    $monto = $row['monto'];
    $aprobador = $row['aprobador'];
    
}

$sql = "SELECT email, full_name FROM system_users WHERE u_userid =".$aprobador;
$query = mysqli_query($bd,$sql);

while($row = mysqli_fetch_array($query))
{
    $correo = $row['email'];
    $nombres = $row['full_name'];
}

$sql1 = "SELECT full_name FROM system_users WHERE cedula =".$cedula;
$query1 = mysqli_query($bd,$sql1);

while($row1 = mysqli_fetch_array($query1))
{
    $user = $row1['full_name'];
}




if($cedula && $imagen && $consecutivo)
{
                
                class PDF extends FPDF
                    {
                        // Cabecera de página
                        function Header()
                            {
                            $this->Image('fondo.jpg','-5','1','240','284', 'JPG');
                            $this->SetFont('Arial','B',12);
                            $this->SetXY(110,20);
                            $this->Ln(25);
                            }
                                            
                    
                            
                    
                    }
                    
                    $pdf = new PDF('P','mm','Letter');
                    $pdf->SetTitle('Solicitud de Anticipo');
                    $pdf->AliasNbPages();
                    $pdf->SetTopMargin(30);
                    $pdf -> addPage();
                
                    
                    
                    $pdf -> Ln(10);
                    $pdf->SetXY(110,20);
                
                    
                    
                    
                    
                    $pdf -> Ln(10);
                    
                    
                    
                    $pdf->Cell(200,20,utf8_decode('SOLICITUD DE ANTICIPO'),0,0,'C',0);
                    $pdf -> Ln(25);
                    $pdf->Write(2, "Fecha: ".$fechaAnticipo);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Nombre del solicitante: ".$nombre),0,0,'L',0);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Cedula: ".$cedula),0,0,'L',0);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Fecha Inicio: ".$inicio),0,0,'L',0);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Fecha Fin: ".$fin),0,0,'L',0);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Descripción: ".$descripcion),0,0,'L',0);
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Valor: $moneda $".number_format($monto)),0,0,'L',0); 
                    if($moneda == "COP")
                      {
                        $pdf -> Ln(5);
                        $pdf->Cell(200,5,utf8_decode("Valor en letras: ".num2letras($monto)." Pesos"),0,0,'L',0);
                      }
                      elseif ($moneda == "USD") 
                      {
                        $pdf -> Ln(5);
                        $pdf->Cell(200,5,utf8_decode("Valor en letras: ".num2letras($monto)." Dolares"),0,0,'L',0);
                      }
                      elseif ($moneda == "EUR") 
                      {
                        $pdf -> Ln(5);
                        $pdf->Cell(200,5,utf8_decode("Valor en letras: ".num2letras($monto)." Euros"),0,0,'L',0);
                      }
                     
                    $pdf -> Ln(8);
                    $pdf ->SetFont('Arial','',10);
                    $pdf ->MultiCell(0,4,utf8_decode("El TRABAJADOR reconoce que el dinero entregado por concepto de anticipo debe ser destinado al objeto señalado en esta solicitud. Por consiguiente, se obliga a legalizarlo con soportes y facturas originales dentro de los 5 días hábiles siguientes a $fechaAnticipo, toda vez que se entiende esta como la fecha de finalización del evento para el cual se ha otorgado el anticipo."), 'I', 'J',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Así mismo, el TRABAJADOR se compromete a seguir con los procedimientos y políticas establecidas por EL EMPLEADOR para la legalización del anticipo."), 'I', 'L',0);
                    $pdf ->MultiCell(0,4,utf8_decode("De igual manera y en el evento en que el anticipo no sea utilizado dentro de los 5 días siguientes a su recibo, el TRABAJADOR se compromete a devolverlo dentro del término y siguiendo el procedimiento establecido en el párrafo anterior."), 'I', 'J',0);
                    $pdf ->MultiCell(0,4,utf8_decode("El TRABAJADOR acepta que el dinero entregado para concepto de anticipo se encuentra bajo su responsabilidad directa, personal y exclusiva. Por ende, en caso de no realizar la legalización o realizar la misma de manera parcial dentro del plazo establecido en los términos indicados por la Compañía o darle un uso indebido al mismo, el TRABAJADOR autoriza expresa e irrevocablemente para que el valor del anticipo pendiente por legalizar sea descontado de sus salarios, prestaciones sociales, vacaciones, indemnizaciones, bonificaciones o cualquier otra acreencia laboral que tuviere a su favor."), 'I', 'J',0);
                    $pdf ->MultiCell(0,4,utf8_decode("En el evento en que por cualquier motivo se termine el contrato de trabajo y no se haya legalizado la totalidad del anticipo, el TRABAJADOR autoriza también en forma expresa e irrevocable para que el EMPLEADOR, del valor final de salarios, prestaciones sociales, vacaciones, indemnizaciones, bonificaciones o cualquier otra acreencia que tuviere a su favor se descuente el valor del anticipo pendiente por legalizar."), 'I', 'J',0);
                    $pdf ->MultiCell(0,4,utf8_decode("En el evento que la liquidación final de prestaciones sociales sea insuficiente para cubrir el valor del anticipo, el TRABAJADOR se compromete a pagar directamente a el EMPLEADOR cualquier saldo a su cargo para lo cual se realizará un acuerdo de pago entre las Partes. Para efecto de soportar dicha obligación, el TRABAJADOR firmará un pagaré en blanco el cual hará parte integral de este Acuerdo."), 'I', 'J',0);
                    $pdf -> Ln(48);
                    $pdf->Line(10, 240, 100, 240);
                    
                    $pdf ->MultiCell(0,4,utf8_decode('Firma del receptor de la transferencia.'), 0, 'L',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("CC. ".$identificacion), 0, 'L',0);
                    $pdf->Image($imagen, 30, 210, 25, 25, 'PNG');
                    
                    $pdf ->MultiCell(0,4,utf8_decode("Nombre del solicitante: ".$nombre), 0, 'L',0);
                    
                    
                    $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
                    $ubicacion = "documento/doc_".time().".pdf";
                    $content = $pdf->Output($ubicacion, "F"); 
                    $sql="UPDATE anticipo SET archivo = '$ubicacion', estado = 1  WHERE consecutivo =".$consecutivo;
                    $query=mysqli_query($bd, $sql);
                    
                    



$mail = new PHPMailer();

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "mail.appmegalabs.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
$mail->Username = "aplicativos@appmegalabs.com"; // Correo completo a utilizar
$mail->Password = "rLgpJ4h&eyO~"; // Contraseña
$mail->Port = 587; // Puerto a utilizar

//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
$mail->From = "aplicativos@appmegalabs.com"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "Administrador";

//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
$mail->AddAddress("$correo"); // Esta es la dirección a donde enviamos


$mail->IsHTML(true); // El correo se envía como HTML
$asunto = "Anticipo ".$consecutivo." pendiente por aprobar";
$mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
$body = "Estimado/a $nombres, <br><br>

El anticipo número $consecutivo del usuario $user esta disponible para su verificación.
<br><br>El enlace para acceder a la plataforma es: <a href='appmegalabs.com'>Appmegalabs.com</a>


<br><br><br>Cordial saludo,
<br><br>Sistema de notificaciones Portal de aplicaciones Megalabs.
<br><br><img width='180' height='70' src='https://appmegalabs.com/scandinavia/assets/img/Megalabs_Logo.png'>";
$mail->Body =utf8_decode( $body); // Mensaje a enviar
$mail->Send();// Envía el correo.
                    
             
                    
                    
                    echo "<script type='text/javascript'>window.top.location='https://appmegalabs.com/scandinavia/aplicaciones/Anticipos/Listados/Empleados/index.php';</script>"; 
                  	
}
                    



?>







