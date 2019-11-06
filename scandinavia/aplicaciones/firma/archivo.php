<?php
    require('fpdf/fpdf.php');
    require('conexion.php');
    require('consultas.php');
    
class PDF extends FPDF
  {
     // Cabecera de página
     function Header()
         {
           $this->Image('pc.png', 10, 10, 20, 20);
           $this->SetFont('Arial','B',12);
           $this->SetXY(110,20);
           $this->Cell(1,10,utf8_decode('CONSENTIMIENTO INFORMADO'),0,0,'C');
           $this->Ln(25);
         }
                        
   
        function Footer() // Pie de página
        {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        
        $this->SetFont('Arial','I',8);
        /* Cell(ancho, alto, txt, border, ln, alineacion)
         * ancho=0, extiende el ancho de celda hasta el margen de la derecha
         * alto=10, altura de la celda a 10
         * txt= Texto a ser impreso dentro de la celda
         * border=T Pone margen en la posición Top (arriba) de la celda
         * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
         * alineación=C Texto alineado al centro
        */
        $this->Cell(0,10,'Este es el pie de página creado con el método Footer() de la clase creada PDF que hereda de FPDF','T',0,'C');
        }
   
 }
        
        
  
    
    
    
    
    
    
    
    $data = new Firma();
    $pdf = new PDF('P','mm','Letter');
    $pdf->SetTitle('Consentimiento informado');
    $pdf->AliasNbPages();
    $pdf->SetTopMargin(30);
    $pdf -> addPage();
   
    
    
    $pdf -> Ln(10);
    
    global $bd;
    $cedula = $a->cedula;
    $sql = "SELECT ubicacion_imagen FROM ubicacionFirma where cedula=$cedula";
    $ejecutar = mysqli_query($bd,$sql);
    while( $datos = mysqli_fetch_array($ejecutar))
    {
        
        $ubicacion_imagen = $datos['ubicacion_imagen'];
         
       
        
        $pdf->Image($ubicacion_imagen, 50, 50, 12, 12, 'PNG');
       
        $pdf -> Ln(10);
    }
    
    
    $pdf->Output();

    ?>
