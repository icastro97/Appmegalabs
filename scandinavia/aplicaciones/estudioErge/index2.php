<?php

require('fpdf/fpdf.php');


 $fechaActual = $_POST['fechaActual'];
 $cedulaMedico = $_POST['cedulaMedico'];
 $nombreMedico = $_POST['nombreMedico'];
 $ciudad = $_POST['ciudad'];
 $codigoPaciente = $_POST['selector1'];
 $siI = $_POST['siI'];
 $noI = $_POST['noI'];
 $siE = $_POST['siE'];
 $noE = $_POST['noE'];
 $fem = $_POST['fem'];
 $mas = $_POST['mas'];
 $peso = $_POST['peso'];
 $talla = $_POST['talla'];
 $estudio = $_POST['estudio'];
 $noH = $_POST['noH'];
 $siH = $_POST['siH'];
 $descripcion = $_POST['descripcion'];
$cedulaingresada = $_POST['cedulalogueada'];


    $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
    mysqli_set_charset($bd,'utf8');

    
        global $bd;
        $sql= "INSERT INTO `formulariochaco`(`estudio`, `fechaActual`, `cedulaMedico`, `nombreMedico`, `ciudad`, `codigoPaciente`, `siI`, `noI`, `siE`, `noE`, `fem`, `mas`, `peso`, `talla`, noH, siH, descripcion) VALUES ( '$estudio', '$fechaActual', '$cedulaMedico','$nombreMedico', '$ciudad', '$codigoPaciente', '$siI', '$noI', '$siE', '$noE','$fem', '$mas','$peso', '$talla', '$noH','$siH','$descripcion')";
        $query = mysqli_query($bd, $sql);
        
        $id = mysqli_insert_id($bd);
        
        
        $sqls="SELECT * from formulariochaco where id_formularioc = ".$id;
        $query=mysqli_query($bd, $sqls);
        while($row = mysqli_fetch_array($query))
        {
            $id1 = $row['id_formularioc'];
            $estudio1 = $row['estudio'];
            $fechaActual1 = $row['fechaActual'];
            $nombreMedico1 = $row['nombreMedico'];
            $ciudad1 = $row['ciudad'];
            $codigoPaciente1 = $row['codigoPaciente'];
            $siL1 = $row['siI'];
            $noL1 = $row['noI'];
            $siE1 = $row['siE'];
            $noE1 = $row['noE'];
            $fem1 = $row['fem'];
            $mas1 = $row['mas'];
            $peso1 = $row['peso'];
            $talla1 = $row['talla'];
            $siH1 = $row['siH'];
            $descripcion1 = $row['descripcion'];
        }
        
        class PDF extends FPDF
            {
                // Cabecera de página
                function Header()
                    {
                        $this->Image('erge.PNG','6','6','200','215', 'PNG');
                        $this->SetFont('Arial','B',12);
                        $this->SetXY(110,20);
                        $this->Ln(25);
                    }
                                    
            
                    
            
            }
            
            $pdf = new PDF('P','mm','Letter');
            $pdf->SetTitle('Historial Clinico');
            $pdf->AliasNbPages();
            $pdf->SetTopMargin(30);
            $pdf -> addPage();
        
            
            
            $pdf -> Ln(10);
            $pdf->SetXY(110,20);
        
           
            
            
            $pdf ->SetFont('Arial','',8);
            $pdf->SetXY(29,65);
            $pdf->MultiCell(200, 20, utf8_decode($fechaActual1), 0, 'L', 0);
            $pdf->SetXY(60,65);
            $pdf->MultiCell(200, 20, utf8_decode($nombreMedico1), 0, 'L', 0);
            $pdf->SetXY(125,65);
            $pdf->MultiCell(200, 20, utf8_decode($ciudad1), 0, 'L', 0);
            $pdf->SetXY(179,65);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($codigoPaciente1), 0, 'L', 0);
            $pdf->SetXY(40,125);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($siL1), 0, 'L', 0);
            $pdf->SetXY(40,125);
            $pdf->MultiCell(200, 20, utf8_decode($noL1), 0, 'L', 0);
            $pdf->SetXY(120,105);
            $pdf->MultiCell(200, 20, utf8_decode($siE1), 0, 'L', 0);
            $pdf->SetXY(120,105);
            $pdf->MultiCell(200, 20, utf8_decode($noE1), 0, 'L', 0);  
            $pdf->SetXY(62,160);
            $pdf->MultiCell(200, 20, utf8_decode($fem1), 0, 'L', 0);
            $pdf->SetXY(62,160);
            $pdf->MultiCell(200, 20, utf8_decode($mas1), 0, 'L', 0);
            $pdf->SetXY(150,158);
            $pdf->MultiCell(200, 20, utf8_decode($peso1), 0, 'L', 0);
            $pdf->SetXY(150,165);
            $pdf->MultiCell(200, 20, utf8_decode($talla1), 0, 'L', 0);
            $pdf->SetXY(40,191);
            $pdf->MultiCell(200, 20, utf8_decode($siH1), 0, 'L', 0);
            $pdf->SetXY(40,200);
            $pdf->MultiCell(200, 20, utf8_decode($descripcion1), 0, 'L', 0);
            $pdf->SetXY(10,230);
            $pdf ->MultiCell(0,4,utf8_decode("Certifico que tengo conocimiento que mi usuario y contraseña empleados para el diligenciamiento del presente formato y/o archivo son de uso absolutamente personal e intransferible y que he cumplido con los protocolos de seguridad. Al completar el diligenciamiento del presente formato y/o archivo, entiendo, autorizo y certifico su equivalencia con la firma autógrafa para todos los efectos éticos y legales. Igualmente certifico que la información aquí consignada ha sido tomada de los datos de la historia clínica del paciente."), 'I', 'J',0);
            $pdf->SetXY(100,248);
            $pdf ->MultiCell(0,4,utf8_decode(FIRMA), 'I', 'J',0);
            $pdf->SetXY(97,255);
            $pdf ->MultiCell(0,4,utf8_decode($cedulaingresada), 'I', 'J',0);
            $pdf->SetXY(80,252);
            $pdf ->MultiCell(0,4,utf8_decode($nombreMedico1), 'I', 'J',0);
            
            $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
            $ubicacion = "../estudioOrca/documento/doc_Erge".time().".pdf";
            $content = $pdf->Output($ubicacion, "F"); 
            $sql="UPDATE formulariochaco SET archivo = '$ubicacion' WHERE id_formularioc =".$id1;
            $query=mysqli_query($bd, $sql);
            $querya ="UPDATE pacientes SET habilitado = 0 WHERE codigoPaciente = '$codigoPaciente1'";
            $ejecutar = mysqli_query($bd, $querya);
           
            
            header('Location: index3.php?id='.$id1);
           
           
            
                   
                   

?>