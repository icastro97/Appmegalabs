<?php

    require('fpdf/fpdf.php');
    require('conexion.php');
    require('consultas.php');
    require ('phpmailer/class.phpmailer.php');
    //require ('AttachMailer.php');
        
     $codigo = $_POST['cod'];
     $nombreP = $_POST['nombreP'];
     $nombreS = $_POST['nombreS'];
     $apellidoP = $_POST['apellidoP'];
     $apellidoS = $_POST['apellidoS'];
     $tipo = $_POST['opcion'];
     $cedula = $_POST['cedula'];
     $nombrem = $_POST['nombrem'];
     $correo = $_POST['correo'];
     $telefono= $_POST['telefono'];
     $fechaActual = $_POST['fechaActual'];                              
     $userid = $_POST['userid'];
     $imagen = $_POST['imagen'];
     $dato = $_POST['dato'];
     $datouno = $_POST['datouno'];
     $datodos = $_POST['datodos'];
     $datotres = $_POST['datotres'];
     $ciudad = $_POST['ciudad'];
     

    
   
    
             $sql = "INSERT INTO `formulario_firma`(codigo, nombremedico, `tipo`, `cedula`, `nombrep`,`nombres`,`apellidop`,`apellidos`, `correo`, `imagen`, `fechaActual`, `userid`, `telefono`, ciudad, `tratamientoDatos`, `publicidad`, `materialCientifico`, `transferenciaValor`) VALUES ('$codigo','$nombrem','$tipo','$cedula', '$nombreP','$nombreS', '$apellidoP', '$apellidoS', '$correo', '$imagen', '$fechaActual', '$userid', '$telefono', '$ciudad', '$dato','$datouno','$datodos', '$datotres')";
             $ejecutar = mysqli_query($bd,$sql);
             $s = mysqli_insert_id($bd);
               
                    
                    
                    $carga = cargarImagen($cedula, $imagen);
                    
                    
                    class PDF extends FPDF
                    {
                        // Cabecera de página
                        function Header()
                            {
                                $this->Image('datospersonales.png','-5','0','222','280', 'PNG');
                                $this->SetFont('Arial','B',12);
                                $this->SetXY(110,20);
                                $this->Ln(25);
                            }
                                        
                    
                            
                    
                    }
                    
                    $pdf = new PDF('P','mm','Letter');
                    $pdf->SetTitle('Autorizacion tratamiento de datos personales Scandinavia');
                    $pdf->AliasNbPages();
                    $pdf->SetTopMargin(30);
                    $pdf -> addPage();
                
                    
                    
                    $pdf -> Ln(10);
                    $pdf->SetXY(110,20);
                
                   
                    
                    
                    
                                                    
                    $pdf ->SetFont('Arial','',7);            
                    $pdf -> Ln(14);
                    $pdf->Write(2, "Fecha: $fechaActual");
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Ciudad: $ciudad"),0,0,'L',0);
                    $pdf -> Ln(8);
                     if($tipo == "CC")
                    {
                        $tipo1 = "Cédula de Ciudadanía";
                    }
                    else if($tipo == "CE")
                    {
                        $tipo2 = "Cédula de Extranjería";
                    }
                    
                    $pdf ->MultiCell(0,4,utf8_decode("Yo $nombreP $nombreS $apellidoP $apellidoS identificado/a con $tipo1 $tipo2  No. $cedula , en virtud de los artículos 9, 10 y 12 de la Ley 1581 de 2012, autorizo de manera libre, voluntaria, previa, explícita, informada e inequívoca a SCANDINAVIA PHARMA LTDA., identificada con NIT. 800.133.807-1 (en adelante 'SCANDINAVIA'), para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja con SCANDINAVIA. Adicionalmente, declaro que tengo conocimiento de los derechos que me asisten en mi calidad de Titular de datos personales, consagrados en el artículo 8 de la Ley 1581 de 2012. "), 'I', 'J',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Esta autorización para el tratamiento de mis datos personales se extiende durante la totalidad del tiempo en el que estos sean requeridos conforme las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja con SCANDINAVIA, y aun con posterioridad a la fecha en que revoque tal autorización, conforme lo estipulado en el literal e) del artículo 8 de la Ley 1581 de 2012, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales fueron inicialmente suministrados. "), 'I', 'J',0);   
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("En ese sentido, declaro conocer que los datos personales objeto de tratamiento, serán utilizados específicamente para las finalidades detalladas con anterioridad en este documento y específicamente: 1. Efectuar las gestiones pertinentes para el desarrollo del objeto social de SCANDINAVIA en lo que tiene que ver con el cumplimiento del objeto de la relación comercial o contractual entre las partes. 2. Realizar invitaciones a eventos y ofrecer nuevos productos y servicios. 3. Gestionar trámites (solicitudes, quejas, reclamos). 4. Efectuar encuestas de satisfacción respecto de los bienes y servicios ofrecidos por SCANDINAVIA. 5. Contactarme(nos) a través de la visita médica o correo electrónico para realizar actividades de promoción de los productos de SCANDINAVIA. 6. Contactarme(nos) a través de correo electrónico para el envío de extractos, estados de cuenta o facturas, encuestas, estudios y/o confirmación de datos personales necesarios para la ejecución de la relación comercial o contractual entre las partes. 7. Suministrar la información a terceros con los cuales SCANDINAVIA tenga relación contractual y que sea necesario entregársela para el cumplimiento de la relación comercial o contractual entre las partes. 8. Suministrar información de contacto a la fuerza comercial y/o red de distribución, telemercadeo, investigación de mercados y cualquier tercero con el cual SCANDINAVIA tenga un vínculo contractual para el desarrollo de actividades de ese tipo (investigación de mercados y telemercadeo, etc.) para la ejecución de las mismas. 9. Conservar la información documental necesaria "), 'I', 'J',0);   
                    $pdf ->MultiCell(0,4,utf8_decode("para corroborar la relación comercial o contractual entre las partes. 4. Efectuar las gestiones pertinentes para el desarrollo del objeto social de SCANDINAVIA en lo que tiene que ver con relación comercial o contractual entre las partes. 5.  Transferir datos personales fuera del país a las compañías afiliadas a SCANDINAVIA para cumplir con las finalidades descritas en este documento y derivados de la relación comercial o contractual entre las partes. "), 'I', 'J',0);
                    $pdf -> Ln(2);
                    $pdf ->MultiCell(0,4,utf8_decode("De igual forma, declaro que me han sido informados y conozco los derechos que el ordenamiento legal y la jurisprudencia, conceden al titular de los datos personales y que incluyen entre otras prerrogativas las que a continuación se relacionan: (i) Conocer, actualizar y rectificar datos personales frente a los responsables o encargados del tratamiento. Este derecho se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o aquellos cuyo tratamiento esté expresamente prohibido o no haya sido autorizado; (ii) solicitar prueba de la autorización otorgada al responsable del tratamiento salvo cuando expresamente se exceptúe como requisito para el tratamiento; (iii) ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a mis datos personales; (iv) presentar ante la Superintendencia de Industria y Comercio quejas por infracciones al régimen de protección de datos personales; (v) revocar la autorización y/o solicitar la supresión del dato personal cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales, (vi) acceder en forma gratuita a mis datos personales que hayan sido objeto de Tratamiento. "), 'I', 'J',0);   
                    $pdf ->MultiCell(0,4,utf8_decode("Por todo lo anterior, he otorgado mi consentimiento a SCANDINAVIA  para que trate mi información personal de acuerdo con la Política de Tratamiento de Datos Personales dispuesta por la sociedad en medio electrónico en el link http://appmegalabs.com/scandinavia/aplicaciones/video/Politicas.php  y que declaro conocer antes de recolectar mis datos personales."), 'I', 'J',0);               
                    if($datouno == "Si")
                    {
                         $pdf -> Ln(2);
                         $pdf ->MultiCell(0,4,utf8_decode("Deseo(amos) que SCANDINAVIA envíe información promocional. "), 'I', 'J',0);            
                    }
                    else
                    {
                        $pdf -> Ln(2);
                        $pdf ->MultiCell(0,4,utf8_decode("No deseo(amos) que SCANDINAVIA envíe información promocional."), 'I', 'J',0);      
                    }
                    if($datodos == "Si")
                    {
                        
                         $pdf ->MultiCell(0,4,utf8_decode("Deseo(amos) que SCANDINAVIA envíe información científica."), 'I', 'J',0); 
                         $pdf ->MultiCell(0,4,utf8_decode("Manifiesto que la presente autorización me fue solicitada y puesta de presente antes de entregar mis datos y que la suscribo de forma libre y voluntaria una vez leída en su totalidad."), 'I', 'J',0);               
                    }
                    else
                    {
                        
                        $pdf ->MultiCell(0,4,utf8_decode("No deseo(amos) que SCANDINAVIA envíe información científica."), 'I', 'J',0);
                        $pdf ->MultiCell(0,4,utf8_decode("Manifiesto que la presente autorización me fue solicitada y puesta de presente antes de entregar mis datos y que la suscribo de forma libre y voluntaria una vez leída en su totalidad."), 'I', 'J',0);               
                    }
                    
                    $pdf -> Ln(6);
                    $pdf->Image($imagen, 10, 210, 55, 25, 'PNG');
                    $pdf->Line(10, 235, 100, 235);
                    $pdf -> Ln(23);
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
        
                    $ubicacion = "documento/doc_".time().".pdf";
                    $content = $pdf->Output($ubicacion, "F"); 
                    $sql="UPDATE formulario_firma  SET pdf = '$ubicacion' WHERE id_consentimiento =". $s;
                    $query=mysqli_query($bd, $sql);
                    
                    
            
                 
        if(!empty($datotres))
        {
            
            
            
            
            $carga = cargarImagen($cedula, $imagen);
            
            
            
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
            $pdf->Image($imagen, 10, 211, 55, 25, 'PNG');
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
            $sql="UPDATE formulario_firma  SET adjuntoDos = '$ubicacion1' WHERE id_consentimiento = ". $s;
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
            $mail->AddAddress($correo); // Esta es la dirección a donde enviamos
            
            $mail->IsHTML(true); // El correo se envía como HTML
            $asunto = "Consentimiento informado destinatarios de transferencias de valor";
            $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
            $body = "Se adjunta el documento de transferencias de valor en pdf.
            <br><br>
            <a href='baja.php'>Darse de baja</a>
            ";
            $mail->Body = $body; // Mensaje a enviar
            $mail->AddStringAttachment(file_get_contents($ubicacion1),'Consentimiento informado destinatarios de transferencias de valor.pdf', 'base64', 'application/pdf');
            
            
            $mail->send();
            
            
            
        }
           
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
            $mail->AddAddress($correo); // Esta es la dirección a donde enviamos
            
            $mail->IsHTML(true); // El correo se envía como HTML
            $asunto = "Autorización tratamiento de datos personales Scandinavia";
            $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
            $body = "Se adjunta la autorización tratamiento de datos personales Scandinavia en pdf.
            <br><br>
            <a href='baja.php'>Darse de baja</a>";
            $mail->Body = utf8_decode($body); // Mensaje a enviar
            $mail->AddStringAttachment(file_get_contents($ubicacion),'Autorizacion tratamiento de datos personales Scandinavia.pdf', 'base64', 'application/pdf');
            
            $mail->send();
           
         $consulta = "SELECT * FROM formulario_firma where id_consentimiento = ".$s;
                    $ejecucion = mysqli_query($bd,$consulta);
                    $numero = mysqli_num_rows($ejecucion);
                    if($numero > 0)
                    {
                        
                      header('Location: alertaBien.php');
                    }
                    else
                    {
                      
                      header('Location: alertaMal.php');
                    }
            
            
        
?>



