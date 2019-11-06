<?php
require('funciones.php');
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
 $sistolica = $_POST['sistolica'];
 $diastolica = $_POST['diastolica'];
 $siro = $_POST['siro'];
 $noro = $_POST['noro'];
 $sica = $_POST['sica'];
 $noca = $_POST['noca'];
 $siman = $_POST['siman'];
 $noman = $_POST['noman'];
 $noH = $_POST['noH'];
 $siH = $_POST['siH'];
 $descripcion = $_POST['descripcion'];
 $estudio = $_POST['estudio'];
 $cedulaingresada = $_POST['cedulalogueada'];


    $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
    mysqli_set_charset($bd,'utf8');

    
        global $bd;
        $sql= "INSERT INTO `formulariochaco`( `estudio`, `fechaActual`, cedulaMedico, `nombreMedico`, `ciudad`, `codigoPaciente`,`siI`, `noI`, `siE`, `noE`, `fem`, `mas`, `peso`, `talla`, `sistolica`, `diastolica`, `siro`, `noro`, `sica`, `noca`, `siman`, `noman`, `noH`, `siH`, `descripcion`) VALUES ( '$estudio', '$fechaActual','$cedulaMedico','$nombreMedico', '$ciudad', '$codigoPaciente','$siI', '$noI', '$siE', '$noE','$fem', '$mas','$peso', '$talla', '$sistolica', '$diastolica','$siro','$noro','$sica', '$noca', '$siman', '$noman', '$noH', '$siH','$descripcion')";
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
            $sistolica1 = $row['sistolica'];
            $diastolica1 = $row['diastolica'];
            $siro1 = $row['siro'];
            $noro1 = $row['noro'];
            $sica1 = $row['sica'];
            $noca1 = $row['noca'];
            $siman1 = $row['siman'];
            $noman1 = $row['noman'];
            $noH1 = $row['noH'];
            $siH1 = $row['siH'];
            $descripcion1 = $row['descripcion'];
        }
        
        class PDF extends FPDF
            {
                // Cabecera de página
                function Header()
                    {
                        $this->Image('estudio5.PNG','2','1','210','240', 'PNG');
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
            $pdf->SetXY(20,73);
            $pdf->MultiCell(200, 20, utf8_decode($fechaActual1), 0, 'L', 0);
            $pdf->SetXY(60, 73);
            $pdf->MultiCell(200, 20, utf8_decode($nombreMedico1), 0, 'L', 0);
            $pdf->SetXY(125,73);
            $pdf->MultiCell(200, 20, utf8_decode($ciudad1), 0, 'L', 0);
            $pdf->SetXY(185,73);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($codigoPaciente1), 0, 'L', 0);
            $pdf->SetXY(40,115);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($siL1), 0, 'L', 0);
            $pdf->SetXY(60,115);
            $pdf->MultiCell(200, 20, utf8_decode($noL1), 0, 'L', 0);
            $pdf->SetXY(120,123);
            $pdf->MultiCell(200, 20, utf8_decode($siE1), 0, 'L', 0);
            $pdf->SetXY(120,123);
            $pdf->MultiCell(200, 20, utf8_decode($noE1), 0, 'L', 0); 
            $pdf->SetXY(24,158);
            $pdf->MultiCell(200, 20, utf8_decode($fem1), 0, 'L', 0);
            $pdf->SetXY(24,158);
            $pdf->MultiCell(200, 20, utf8_decode($mas1), 0, 'L', 0);
            $pdf->SetXY(100,163);
            $pdf->MultiCell(200, 20, utf8_decode($peso1), 0, 'L', 0);
            $pdf->SetXY(100,172);
            $pdf->MultiCell(200, 20, utf8_decode($talla1), 0, 'L', 0);
            $pdf->SetXY(160,163);
            $pdf->MultiCell(200, 20, utf8_decode($sistolica1), 0, 'L', 0);
            $pdf->SetXY(160,168);
            $pdf->MultiCell(200, 20, utf8_decode($diastolica1), 0, 'L', 0);
            $pdf->SetXY(24,205);
            $pdf->MultiCell(200, 20, utf8_decode($siro1), 0, 'L', 0);
            $pdf->SetXY(24,205);
            $pdf->MultiCell(200, 20, utf8_decode($noro1), 0, 'L', 0);
            $pdf->SetXY(80,205);
            $pdf->MultiCell(200, 20, utf8_decode($sica1), 0, 'L', 0);
            $pdf->SetXY(80,205);
            $pdf->MultiCell(200, 20, utf8_decode($noca1), 0, 'L', 0);
            $pdf->SetXY(124,205);
            $pdf->MultiCell(200, 20, utf8_decode($siman1), 0, 'L', 0);
            $pdf->SetXY(124,205);
            $pdf->MultiCell(200, 20, utf8_decode($noman1), 0, 'L', 0);
            $pdf->SetXY(24,215);
            $pdf->MultiCell(200, 20, utf8_decode($siH1), 0, 'L', 0);
            $pdf->SetXY(24,215);
            $pdf->MultiCell(200, 20, utf8_decode($noH1), 0, 'L', 0);
            $pdf ->SetFont('Arial','',5);
            $pdf->SetXY(10,239);
            $pdf ->MultiCell(0,4,utf8_encode("Certifico que tengo conocimiento que mi usuario y contrasena empleados para el diligenciamiento del presente formato y/o archivo son de uso absolutamente personal e intransferible y que he cumplido con los protocolos de seguridad. Al completar el diligenciamiento del presente formato y/o archivo, entiendo, autorizo y certifico su equivalencia con la firma autografa para todos los efectos eticos y legales. Igualmente certifico que la informacion aqui consignada ha sido tomada de los datos de la historia clinica del paciente."), 'I', 'J',0);
            $pdf->SetXY(100,250);
            $pdf ->MultiCell(0,4,utf8_decode(FIRMA), 'I', 'J',0);
            $pdf->SetXY(97,255);
            $pdf ->MultiCell(0,4,utf8_decode($cedulaingresada), 'I', 'J',0);
            $pdf->SetXY(87,253);
            $pdf ->MultiCell(0,4,utf8_decode($nombreMedico1), 'I', 'J',0);
            if($siH1 == "Si")
            {
                $pdf->SetXY(31,220);
                $pdf->MultiCell(200, 20, utf8_decode("Descripción: "), 0, 'L', 0);
                $pdf->SetXY(51,220);
                $pdf->MultiCell(200, 20, utf8_decode($descripcion1), 0, 'L', 0);
                
            }
            else
            {
                $pdf->SetXY(31,220);
                $pdf->MultiCell(200, 20, utf8_decode("Descripción: "), 0, 'L', 0);
                $pdf->SetXY(51,220);
                $pdf->MultiCell(200, 20, utf8_decode("No aplica"), 0, 'L', 0);
            }
            
            
            $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
            $ubicacion = "documento/doc_Orca".time().".pdf";
            $content = $pdf->Output($ubicacion, "F"); 
            $sql="UPDATE formulariochaco SET archivo = '$ubicacion' WHERE id_formularioc =".$id1;
            $query=mysqli_query($bd, $sql);
            $querya ="UPDATE pacientes SET habilitado = 0 WHERE codigoPaciente = '$codigoPaciente'";
           $ejecutar = mysqli_query($bd, $querya);
           
            header('Location: index3.php?id='.$id1);
           
                   
                   

?>
