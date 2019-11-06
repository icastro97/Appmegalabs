<?php
//require ('phpmailer/class.phpmailer.php');
require('fpdf/fpdf.php');
require('conexion.php');


$fechaActual = $_POST['fechaActual'];
$nombrem = $_POST['nombremedico'];
$codigo = $_POST['codigom'];
$tipo = $_POST['opc'];
$cedula = $_POST['cedula'];
$nombreP = $_POST['nombreP'];
$nombreS = $_POST['nombreS'];
$apellidoP = $_POST['apellidoP'];
$apellidoS = $_POST['apellidoS'];
$correo = $_POST['correo'];
$tel = $_POST['tel'];
$userid = $_POST['userid'];
$ciudad = $_POST['ciudad'];
$datos3 = $_POST['datos3'];
$imagen = $_POST['imagen'];
$userid = $_POST['userid'];
$tipoDocumento = $_POST['tipoDocumento'];

       
            
                                 
             
        global $bd;
        $sql = "SELECT codigo, cedula FROM formulario_firma WHERE codigo = '$codigo' or cedula = '$cedula'";
        $eje = mysqli_query($bd, $sql);
        $numeroForm = mysqli_num_rows($eje);
        if($numeroForm != 0)
        {
                
                $actualizarTablaUno = "UPDATE formulario_firma SET codigo = '$codigo' , nombremedico = '$nombrem', `tipo` = '$tipo', `cedula` = '$cedula', `nombrep` = '$nombreP',`nombres` = '$nombreS',`apellidop` = '$apellidoP' ,`apellidos` = '$apellidoS', `correo`  = '$correo', `imagen` = '$imagen', `fechaActual` = '$fechaActual', `telefono` = '$tel', ciudad = '$ciudad', `transferenciaValor` = '$datos3', userid = '$userid'  WHERE codigo = '$codigo' or cedula = '$cedula'";
                $ejecucion = mysqli_query($bd, $actualizarTablaUno);
                
                $sql = "INSERT INTO `formulario_firma2`(tipo2,codigo, nombremedico, `tipo`, `cedula`, `nombrep`,`nombres`,`apellidop`,`apellidos`, `correo`, `imagen`, `fechaActual`, `telefono`, ciudad, `transferenciaValor`, userid, fechaActualizacion) VALUES ('$tipoDocumento','$codigo','$nombrem','$tipo','$cedula', '$nombreP','$nombreS', '$apellidoP', '$apellidoS', '$correo', '$imagen', '$fechaActual', '$tel', '$ciudad', '$datos3', '$userid', NOW())";
                //var_dump($sql);
                $ejecutar = mysqli_query($bd,$sql);
                $s = mysqli_insert_id($bd);
                
                 $data = 'data:image/png;base64,iVBORw0K';
                    list($type, $imagen) = explode(';', $imagen);
                    list(,$extension) = explode('/',$type);
                    list(,$imagen)      = explode(',', $imagen);
                    $carpeta = 'prueba/'.uniqid().'.'.$extension;
                    $imagen = base64_decode($imagen);
                    file_put_contents($carpeta, $imagen);
                    
                    
                    global $bd;
                    $sql2 = "INSERT INTO ubicacionFirma(cedula, ubicacion_imagen) VALUES ('$cedula','$carpeta')";
                    $ejecutar2 = mysqli_query($bd,$sql2);
                
                
                 class PDF2 extends FPDF
                    {
                       
                        function Header()
                            {
                                $this->Image('pruebatrasnferencia1.png','-5','0','222','280', 'PNG');
                                $this->SetFont('Arial','B',12);
                                $this->SetXY(110,20);
                                $this->Ln(25);
                            }                    
                    
                            
                    
                    }
                    $pdf = new PDF2('P','mm','Letter');
                    $pdf->SetTitle('CONSENTIMIENTO INFORMADO DESTINATARIOS DE TRANSFERENCIA DE VALOR');
                    $pdf->AliasNbPages();
                    $pdf->SetTopMargin(30);
                    $pdf -> addPage();
                
                    
                    
                    $pdf -> Ln(10);
                    $pdf->SetXY(110,20);
                
                   
                    $pdf ->SetFont('Arial','',7);
                    $pdf -> Ln(10);
                    $pdf->Write(2, "Fecha: $fechaActual");
                    $pdf -> Ln(2);
                    $pdf->Cell(200,5,utf8_decode("Ciudad:  $ciudad"),0,0,'L',0);
                    $pdf -> Ln(7);
                     if($tipo == "CC")
                    {
                        $tipo1 = "Cédula de Ciudadanía";
                    }
                    else if($tipo == "CE")
                    {
                        $tipo2 = "Cédula de Extranjería";
                    }
                    $pdf ->MultiCell(0,4,utf8_decode("Yo $nombreP $nombreS $apellidoP $apellidoS identificado/a con $tipo1 $tipo2 No. $cedula, en virtud de los artículos 9, 10 y 12 de la Ley 1581 de 2012, autorizo de manera libre, voluntaria, previa, explícita, informada e inequívoca a SCANDINAVIA PHARMA LTDA., identificada con NIT. 800.133.807-1 (en adelante 'SCANDINAVIA'), para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja con SCANDINAVIA, en desarrollo y ejecución de los fines descritos en la Resolución 2881 de 2018 del Misterio de Salud y Protección Social, las normas que la regulen o sustituyan."), 'I', 'J',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Asimismo, autorizo al Misterio de Salud y Protección Social para que publique la información que sea reportada a mi nombre por parte de SCANDINAVIA para el Registro de Transferencias de Valor del Sector Salud, definidas en el artículo 2 de la Resolución 2881 de 2018 del mencionado Ministerio, las normas que la regulen o sustituyan y según los términos establecidos por la misma. Adicionalmente, autorizo al Ministerio de Salud y Protección Social el publicar el valor de la Transferencias de Valor del Sector Salud reportadas, así como la finalidad específica de la publicación para la cual se obtiene el consentimiento. "), 'I', 'J',0);   
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Soy consciente de que la mencionada publicación de información se realiza en aras de garantizar la transparencia las relaciones entre actores del sector salud y la industria farmacéutica y de tecnologías en salud. Además, declaro que tengo conocimiento de los derechos que me asisten en mi calidad de Titular de datos personales, consagrados en el artículo 8 de la Ley 1581 de 2012."), 'I', 'J',0);   
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Esta autorización para el tratamiento de mis datos personales se extiende durante la totalidad del tiempo en el que estos sean requeridos conforme la Resolución 2881 de 2018 del Misterio de Salud y Protección Social, las normas que la regulen o sustituyan, y aun con posterioridad a la fecha en que revoque tal autorización, conforme lo estipulado en el literal e) del artículo 8 de la Ley 1581 de 2012, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales fueron inicialmente suministrados. "), 'I', 'J',0);   
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("En ese sentido, declaro conocer que los datos personales objeto de tratamiento, serán utilizados específicamente para las finalidades derivadas de la Resolución 2881 de 2018 del Misterio de Salud y Protección Social, las normas que la regulen o sustituyan, y específicamente: 1. Reportar las transferencias de Valor del Sector Salud que me sean realizadas indirectamente, por intermedio o a favor de terceros, definidas en los artículos 6, 7 y 8 de la Resolución 2881 de 2018 del Misterio de Salud y Protección Social, las normas que la regulen o sustituyan. 2. Corregir, actualizar o suprimir las Transferencias de Valor del Sector Salud reportadas, conforme reclamo presentado ante SCANDINAVIA con copia al Ministerio de Salud y Protección Social, según lo dispuesto en los artículos 16 y 17 de la Ley 1266 de 2008 y en concordancia con los artículos 15 y 16 de la Ley 1581 de 2012. 3. Conservar la información documental necesaria para corroborar la realización de las Transferencias de Valor del Sector Salud reportadas. 4. Efectuar las gestiones pertinentes para el desarrollo del objeto social de SCANDINAVIA en lo que tiene que ver con el cumplimiento del objeto de la relación comercial o contractual con el Titular de la información. 5.  Transferir datos personales fuera del país a las compañías afiliadas a SCANDINAVIA para cumplir con las regulaciones de la Resolución 2881 de 2018 del Misterio de Salud y Protección Social, las normas que la regulen o sustituyan. "), 'I', 'J',0);
                    $pdf -> Ln(3);
                    $pdf ->MultiCell(0,4,utf8_decode("De igual forma, declaro que me han sido informados y conozco los derechos que el ordenamiento legal y la jurisprudencia, conceden al titular de los datos personales y que incluyen entre otras prerrogativas las que a continuación se relacionan: (i) Conocer, actualizar y rectificar datos personales frente a los responsables o encargados del tratamiento. Este derecho se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o aquellos cuyo tratamiento esté expresamente prohibido o no haya sido autorizado; (ii) solicitar prueba de la autorización otorgada al responsable del tratamiento salvo cuando expresamente se exceptúe como requisito para el tratamiento; (iii) ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a mis datos personales; (iv) presentar ante la Superintendencia de Industria y Comercio quejas por infracciones al régimen de protección de datos personales; (v) revocar la autorización y/o solicitar la supresión del dato personal cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales, (vi) acceder en forma gratuita a mis datos personales que hayan sido objeto de Tratamiento. "), 'I', 'J',0);                     
                    $pdf -> Ln(2);
                    $pdf ->MultiCell(0,4,utf8_decode("Por todo lo anterior, he otorgado mi consentimiento a SCANDINAVIA  para que trate mi información personal de acuerdo con la Política de Tratamiento de Datos Personales dispuesta por la sociedad en medio electrónico en el link http://appmegalabs.com/scandinavia/aplicaciones/video/Politicas.php  y que declaro conocer antes de recolectar mis datos personales."), 'I', 'J',0);               
                    $pdf -> Ln(2);
                    $pdf ->MultiCell(0,4,utf8_decode("Manifiesto que la presente autorización me fue solicitada y puesta de presente antes de entregar mis datos y que la suscribo de forma libre y voluntaria una vez leída en su totalidad. "), 'I', 'J',0);                                 
                    $pdf -> Ln(5);
                    $pdf->Image($carpeta, 10, 211, 55, 25, 'PNG');
                    $pdf->Line(10, 235, 100, 235);
                    $pdf -> Ln(20);
                    $pdf ->MultiCell(0,4,utf8_decode("Firma"), 0, 'L',0);
                    $pdf ->MultiCell(0,4,utf8_decode("Nombre: $nombreP $nombreS $apellidoP $apellidoS"), 0, 'L',0);
                    $pdf ->MultiCell(0,4,utf8_decode("Documento: $cedula"), 0, 'L',0);
                    if($telefono)
                    {
                        $pdf ->MultiCell(0,4,utf8_decode("Telefono(opcional): $telefono"), 0, 'L',0);
                    }
                    else
                    {
                        $pdf ->MultiCell(0,4,utf8_decode("Telefono(opcional): "), 0, 'L',0);
                    }
                    $pdf ->MultiCell(0,4,utf8_decode("Este documento fue enviado al correo: $correo"), 0, 'L',0);
                    
                    $ubicacion1 = "documento/docotro_".time().".pdf";
                    $content = $pdf->Output($ubicacion1, "F"); 
                    $sqlb ="UPDATE formulario_firma  SET adjuntoDos = '$ubicacion1' WHERE cedula = ". $cedula;
                    $querys=mysqli_query($bd, $sqlb);
                    $sqla ="UPDATE formulario_firma2  SET documentoTransferencia  = '$ubicacion1' WHERE id_consentimiento = ". $s;
                    $query=mysqli_query($bd, $sqla);
                    $result= '';
                    if($query == TRUE){
                        $result = "bien";
                        echo $result;
                    }
                    else{
                        $result = "mal";
                        echo $result;
                    }
        }
        else
        {
                 $result = "mal";
                 echo $result;
        }
      
?>