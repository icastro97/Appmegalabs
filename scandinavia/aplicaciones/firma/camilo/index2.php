<?php

    //require('fpdf/fpdf.php');
    require('conexion.php');
    //require('consultas.php');
    //require ('phpmailer/class.phpmailer.php');

        
        $tipo = $_POST['opcion'];
        $cedula = $_POST['cedula'];
        $nombre= $_POST['nombre'];
        $correo= $_POST['correo'];
        $ciudad = $_POST['ciudad'];
        $fechaActual = $_POST['fechaActual'];
        $userid = $_POST['userid'];

       

        
       /* if($cedula && $nombre && $apellido && $correo && $imagen && $fechaActual && $userid && $ciudad)
        {
            
            $insertar = insertarDatos($cedula, $nombre, $apellido, $correo, $imagen, $fechaActual,$userid, $ciudad);
            $carga = cargarImagen($cedula, $imagen);
           
            // Creación del pdf
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
                $pdf->SetTitle('Consentimiento informado');
                $pdf->AliasNbPages();
                $pdf->SetTopMargin(30);
                $pdf -> addPage();
               
                
                
                $pdf -> Ln(10);
                $pdf->SetXY(110,20);
               
                
                
                
                
                $pdf -> Ln(10);
                global $bd;
                $sql = "SELECT * FROM ubicacionFirma where cedula=$cedula";
                $ejecutar = mysqli_query($bd,$sql);
                while( $datos = mysqli_fetch_array($ejecutar))
                {
                    //$nombre = $datos['nombres'];
                    //$apellido = $datos ['apellidos'];
                   //$ubicacion_imagen = $datos['ubicacion_imagen'];
                    //$cedula = $datos['cedula']; 
                    
                    
                    //$pdf->Image($ubicacion_imagen, 100, 100, 12, 12, 'PNG');
                    
                    $pdf -> Ln(10);
                    
                }
                
                 $pdf ->SetFont('Arial','I',9);
                $pdf -> Ln(16);
                $pdf ->MultiCell(0,4,utf8_decode('Continuación de la resolución "Por la cual se crea el Registro de Transferencia de Valor entre actores del sector salud y la insdustria farmacéutica y de tecnologías en salud."'), 'B', 'C',0);
                $pdf -> Ln(2);
                $pdf ->SetFont('Arial','B',12);
                $pdf->Cell(200,5,utf8_decode('Anexo Técnico 2'),0,0,'C',0);
                $pdf -> Ln(5);
                $pdf ->SetFont('Arial','B',10);
                $pdf ->MultiCell(0,4,utf8_decode('"Modelo minimo de información que deberá contener el consentimiento previo, expreso e informado, para el Registro de Transferencia de Valor del Sector Salud".'), 0, 'C',0);
                $pdf -> Ln(5);
                $pdf->Cell(200,20,utf8_decode('CONSENTIMIENTO INFORMADO'),0,0,'C',0);
                $pdf -> Ln(25);
                $pdf->Write(2, "Fecha: $fechaActual");
                $pdf -> Ln(5);
                $pdf->Cell(200,5,utf8_decode("Ciudad: $ciudad"),0,0,'L',0);
                $pdf -> Ln(8);
                $pdf ->SetFont('Arial','',10);
                $pdf ->MultiCell(0,4,utf8_decode("Yo $nombre.$apellido, identificado con CC $cedula, en mi calidad de representante legal de(nombre o razón social de la persona o institución receptora de transferencia de valor): xxxxxxxxx con NIT xxxxxxxxxxxx; en virtud de los articulos 9° y 12° de la Ley 1581 de 2012, autorizo en forma permanente al ministerio de Salud y Protección Social, para que publique la información que sea reportada a mi nombre por parte de la institución SCANDINAVIA PHAMRA LTDA, identificado/a con NIT No. 800 133 807-1, al Registro de Transferencias de Valor del Sector Salud establecido por el Ministerio de Salud y Protección Social. "), 'I', 'L',0);
                $pdf -> Ln(4);
                $pdf ->MultiCell(0,4,utf8_decode("Soy consciente de que la mencionada publicación de información se realiza en aras de garantizar la transparencia las relaciones entre actores del sector salud y la industria farmaceutica y de tecnologías en salud. Además, declaro que tengo conocimiento de los derechos que me asisten en mi calidad de Titular de datos personales, consagrados en el articulo 8° de la Ley 1581 de 2012."), 'I', 'L',0);
                $pdf->Line(10, 200, 100, 200);
                $pdf -> Ln(48);
                $pdf ->MultiCell(0,4,utf8_decode('Firma del receptor de la transferencia.'), 0, 'L',0);
                $pdf -> Ln(4);
                $pdf ->MultiCell(0,4,utf8_decode("CC. $cedula"), 0, 'L',0);
                $pdf->Image($imagen, 30, 174, 25, 25, 'PNG');
                $pdf ->MultiCell(0,4,utf8_decode("Este documento fue enviado al correo: $correo"), 0, 'L',0);
                $doc = $pdf->Output('');
                
         
               /* $mail = new PHPMailer();
                $mail->From = 'aplicativos@appscandinavia.com';
                $mail->FromName = 'Administrador';
                $mail->Subject = 'Consentimiento informado';
                $mail->Body = 'Se adjunta el reporte en pdf';
                $mail->AddAddress($correo);
                $mail->AddAddress('juansebastian.condefarias@gmail.com');
               
                // definiendo el adjunto 
                $mail->AddStringAttachment($doc, 'doc.pdf', 'base64', 'application/pdf');
                // enviando
                $mail->Send();
                 header('location: respuesta.php'); 
               
           
        }
        else
        {
            header('location: rechazo.php'); 
        }
        */
        
        
        

?>



