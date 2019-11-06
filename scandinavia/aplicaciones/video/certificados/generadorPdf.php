<?php

    require('fpdf/fpdf.php');
    require('conexion.php');
    //require('consultas.php');
    //require ('phpmailer/class.phpmailer.php');
    //require ('AttachMailer.php');
        
     $nit = $_POST['nitEscondido'];
     $ano = $_POST['select'];
     

    
   
    
             $sql = "SELECT `id`, `nit`, `nombre`, `ano`, `tipo`, `tarifa`, `periodo`, `baseSujeta`, `valorRetenido` FROM `retenciones` WHERE nit = '$nit' and ano = '$ano'";
             $ejecutar = mysqli_query($bd,$sql);
             while($row = mysqli_fetch_array($ejecutar))
             {
                 $nit1 = $row['nit'];
                 $nombre = $row['nombre'];
                 $ano = $row['ano'];
                 $tipo = $row['tipo'];
                 $tarifa = $row['tarifa'];
                 $periodo = $row['periodo'];
                 $baseSujeta = $row['baseSujeta'];
                 $valorRetenido = $row['valorRetenido'];
             }
               
                    
                    
                    
                    
                    
                    class PDF extends FPDF
                    {
                        // Cabecera de página
                        function Header()
                            {
                                $this->Image('hoja.jpg','-5','0','222','280', 'JPG');
                                $this->SetFont('Arial','B',12);
                                $this->SetXY(110,20);
                                $this->Ln(25);
                            }
                                        
                        function cabeza($cabecera)
                        {
                            
                            $this->SetFont('Arial','B',10);
                            foreach($cabecera as $fila)
                            {
                                
                                //$this->Cell(20,10, utf8_decode($fila[0]),1, 0 , 'L' ); 
                                //$this->Cell(50,10, utf8_decode($fila[1]),1, 0 , 'L' );
                                //$this->Cell(10,10, utf8_decode($fila[2]),1, 0 , 'L' );
                                //$this->Cell(20,10, utf8_decode($fila[3]),1, 0 , 'L' );
                                ///$this->Cell(20,10, utf8_decode($fila[4]),1, 0 , 'L' );
                                //$this->Cell(20,10, utf8_decode($fila[5]),1, 0 , 'L' );
                                $this->SetXY(18,120);
                                $this->MultiCell(20,15.9, utf8_decode($fila[0]),1, 'L',0);
                                $this->SetXY(38,120);
                                $this->MultiCell(50,15.9, utf8_decode($fila[1]),1, 'L',0);
                                $this->SetXY(88,120);
                                $this->MultiCell(10,15.9, utf8_decode($fila[2]),1, 'L',0);
                                $this->SetXY(98,120);
                                $this->MultiCell(20,15.9, utf8_decode($fila[3]),1, 'L',0);
                                $this->SetXY(118,120);
                                $this->MultiCell(20,15.9, utf8_decode($fila[4]),1, 'L',0);
                                $this->SetXY(138,120);
                                $this->MultiCell(20,15.9, utf8_decode($fila[5]),1, 'L',0);
                                $this->SetXY(158,120);
                                $this->MultiCell(20,5.3, utf8_decode($fila[6]),1, 'L',0);
                                $this->SetXY(178,120);
                                $this->MultiCell(20,4, utf8_decode($fila[7]),1, 'L',0);
                                
                                
                                
                                //Atención!! el parámetro valor 0, hace que sea horizontal
                                
                            }
                        }
                            
                    
                    }
                    
                    $pdf = new PDF('P','mm','Letter');
                    $pdf->SetTitle('');
                    $pdf->AliasNbPages();
                    $pdf->SetTopMargin(30);
                    $pdf -> addPage();
                    
                    
                    
                    $pdf -> Ln(10);
                    $pdf->SetXY(110,20);
                
                   
                    
                    
                    
                                                    
                         
                    
                    $pdf->SetY(60);
                    $pdf->SetX(90);
                    $pdf->SetFont('Arial','B',10); 
                    $pdf->Cell(10,10,"Scandinavia Pharma Ltda.");
                    $pdf->SetY(65);
                    $pdf->SetX(99);
                    $pdf->Cell(10,10,"Nit 800133807-1");
                    
                    $pdf ->SetFont('Arial','',10);       
                    $pdf->SetY(70);
                    $pdf->SetX(93);
                    $pdf->Cell(10,10,"Calle 106 Nro. 18 A 45");
                    $pdf->SetY(75);
                    $pdf->SetX(96);
                    $pdf->Cell(10,10,"Barrio San Patricio");
                    $pdf->SetY(80);
                    $pdf->SetX(102);
                    $pdf->Cell(10,10,utf8_decode("Bogotá D.C."));
                    $pdf->SetY(85);
                    $pdf->SetX(104);
                    $pdf->Cell(10,10,"Colombia ");
                    $pdf->SetY(90);
                    $pdf->SetX(83);
                    $pdf->SetFont('Arial','B',10); 
                    $pdf->Cell(10,10,"CERTIFICADO DE RETENCIONES");
                    $pdf->SetY(95);
                    $pdf->SetX(92);
                    $pdf->SetFont('Arial','B',10); 
                    $pdf->Cell(10,10,utf8_decode("AÑO GRAVABLE $ano "));
                    $pdf->SetY(105);
                    $pdf->SetX(17);
                    $pdf->Cell(10,10,"RAZON SOCIAL / NOMBRE: ");
                    $pdf ->SetFont('Arial','',10); 
                    $pdf->SetY(105);
                    $pdf->SetX(78);
                    $pdf->Cell(10,10, $nombre);
                    $pdf->SetY(110);
                    $pdf->SetX(17);
                    $pdf->SetFont('Arial','B',10); 
                    $pdf->Cell(10,10,"NIT / CEDULA: ");
                    $pdf->SetY(110);
                    $pdf->SetX(78);
                    $pdf ->SetFont('Arial','',10); 
                    $pdf->Cell(10,10, $nit1);
                 
                    $miCabecera[] = array('Nit', 'Nombre', 'Año','Tipos',  'Tarifa', 'Periodo', 'Base Sujeta a Retencion', 'Base Sujeta a Retencion ReteIva', 'Valor Retenido');
                    
                    
                    
                    
                    $pdf -> Ln(14);
                    //$pdf->Write(10, "Nit: $nit");
                    $pdf -> Ln(5);
                    //$pdf->Cell(200,5,utf8_decode("Ciudad: ciudad"),0,0,'L',0);
                    $pdf -> Ln(8);
                    
                    $pdf->SetX(50);
                    $pdf->cabeza($miCabecera);
                    
                    $pdf ->SetFont('Arial','',10); 
                    foreach($ejecutar as $rows)
                    {
                        $nits =  $rows['nit'];
                        $nombreCompañia = $rows['nombre'];
                        $tipos = $rows['tipo'];
                        $tarifa1 = $rows['tarifa'];
                        $ano1 = $rows['ano'];
                        $periodo1 = $rows['periodo'];
                        $baseSujeta1 = $rows['baseSujeta'];
                        $valorRetenido1 = $rows['valorRetenido'];
                        
                        
                              
                              $pdf->SetX(18);
                               
                              
                              $pdf->Cell(20,5, $nits,1);
                              $pdf->Cell(50,5,$nombreCompañia,1);
                              $pdf->Cell(10,5,$ano1,1);
                              $pdf->Cell(20,5,$tipos,1);
                              $pdf->Cell(20,5,$tarifa1,1);
                              $pdf->Cell(20,5,$periodo1,1);
                              $pdf->Cell(20,5,$baseSujeta1,1);
                              $pdf->Cell(20,5,$valorRetenido1,1);
                              
                              $pdf->Ln();
                    }
                    
                    $dia=date('d');
                    $fecha =date('d-m-Y H:i:s');
                    $fechas =  fechaCastellano($Fecha);
                    $pdf -> Ln(8);
                    $pdf->SetY(180);
                    $pdf->SetX(15);
                    $pdf ->MultiCell(0,4,utf8_decode("El valor retenido fue consignado oportunamente a la Dirección de Impuestos y Aduanas Nacionales de Bogotá D.C"), 'I', 'J',0);
                    $pdf->SetY(190);
                    $pdf->SetX(15);
                    $pdf ->MultiCell(0,4,utf8_decode("Este Certificado se expide el día ($dia) del mes$fechas, de conformidad con lo establecido en el artículo 381 del Estatuto Tributario y demás normas concordantes."), 'I', 'J',0);
                    $pdf->SetY(200);
                    $pdf->SetX(15);
                    $pdf->SetFont('Arial','B',10); 
                    $pdf ->MultiCell(0,4,utf8_decode("No necesita firma autorizada, Según Art 10 Dr. 836/91"), 'I', 'J',0);
                    
                    
                    $ubicacion = "documento/doc_".time().".pdf";
                    $content = $pdf->Output($ubicacion, "I"); 
                    
            
                 
       
function fechaCastellano ($fecha) 
{
            $fecha = substr($fecha, 0, 10);
            $mes = date('F', time($fecha));
            $anio = date('Y', time($fecha));
            $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
            return $nombredia."".$numeroDia." de ".$nombreMes." de ".$anio;
}

?>



