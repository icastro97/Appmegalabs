<?php

require('fpdf/fpdf.php');

class PDF extends FPDF
                    {
                        // Cabecera de página
                        function Header()
                            {
                            $this->Image('estudio.PNG','-5','1','240','284', 'PNG');
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
                    $pdf->Write(2, "Fecha: ");
                    $pdf -> Ln(5);
                    $pdf->Cell(200,5,utf8_decode("Ciudad: "),0,0,'L',0);
                    $pdf -> Ln(8);
                    $pdf ->SetFont('Arial','',10);
                    $pdf ->MultiCell(0,4,utf8_decode("Yo , identificado con CC , en mi calidad de representante legal de(nombre o razón social de la persona o institución receptora de transferencia de valor): xxxxxxxxx con NIT xxxxxxxxxxxx; en virtud de los articulos 9° y 12° de la Ley 1581 de 2012, autorizo en forma permanente al ministerio de Salud y Protección Social, para que publique la información que sea reportada a mi nombre por parte de la institución SCANDINAVIA PHAMRA LTDA, identificado/a con NIT No. 800 133 807-1, al Registro de Transferencias de Valor del Sector Salud establecido por el Ministerio de Salud y Protección Social. "), 'I', 'L',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("Soy consciente de que la mencionada publicación de información se realiza en aras de garantizar la transparencia las relaciones entre actores del sector salud y la industria farmaceutica y de tecnologías en salud. Además, declaro que tengo conocimiento de los derechos que me asisten en mi calidad de Titular de datos personales, consagrados en el articulo 8° de la Ley 1581 de 2012."), 'I', 'L',0);
                    $pdf->Line(10, 200, 100, 200);
                    $pdf -> Ln(48);
                    $pdf ->MultiCell(0,4,utf8_decode('Firma del receptor de la transferencia.'), 0, 'L',0);
                    $pdf -> Ln(4);
                    $pdf ->MultiCell(0,4,utf8_decode("CC. "), 0, 'L',0);
                    
                    
                    $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
                    $ubicacion = "documento/doc_".time().".pdf";
                    $content = $pdf->Output($ubicacion, "F"); 
                    $sql="UPDATE formularios SET archivo = '$ubicacion' WHERE id_formulario =".$id_formulario;
                    $query=mysqli_query($bd, $sql);
                    
                    echo "Se genero el documento";
                    
?>
