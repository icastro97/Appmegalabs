<?php
require('fpdf/fpdf.php');



 $fechaActual = $_POST['fechaActual'];
 $cedulaMedico = $_POST['cedulaMedico'];
 $nombreMedico = $_POST['nombreMedico'];
 $ciudad = $_POST['ciudad'];
 $codigoPaciente = $_POST['selector1'];
 $estudio = $_POST['estudio'];
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
 $nocol = $_POST['nocol'];
 $sicol = $_POST['sicol'];
 $colesterol = $_POST['colesterol'];
 $nocolh = $_POST['nocolh'];
 $sicolh = $_POST['sicolh'];
 $colesterolh = $_POST['colesterolh'];
 $notri = $_POST['notri'];
 $sitri = $_POST['sitri'];
 $trigli = $_POST['trigli'];
 $nogli = $_POST['nogli'];
 $sigli = $_POST['sigli'];
 $gli = $_POST['gli'];
 $nohe = $_POST['nohe'];
 $sihe = $_POST['sihe'];
 $hemo = $_POST['hemo'];
 $nocre = $_POST['nocre'];
 $sicre = $_POST['sicre'];
 $cre = $_POST['cre'];
 $noac = $_POST['noac'];
 $siac = $_POST['siac'];
 $aci = $_POST['aci'];
 $noal = $_POST['noal'];
 $sial = $_POST['sial'];
 $alb = $_POST['alb'];
 $noH = $_POST['noH'];
 $siH = $_POST['siH'];
 $descripcion = $_POST['descripcion'];
  $cedulaingresada = $_POST['cedulalogueada'];
 
 $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
    mysqli_set_charset($bd,'utf8');

    
        global $bd;
        $sql= "INSERT INTO `formulariochaco`(`estudio`, `fechaActual`, `cedulaMedico`, `nombreMedico`, `ciudad`, `codigoPaciente`, `siI`, `noI`, `siE`, `noE`, `fem`, `mas`, `peso`, `talla`, `sistolica`, `diastolica`, `nocol`, `sicol`, `colesterol`, `nocolh`, `sicolh`, `colesterolh`, `notri`, `sitri`, `trigli`, `nogli`, `sigli`, `gli`, `nohe`, `sihe`, `hemo`, `nocre`, `sicre`, `cre`, `noac`, `siac`, `aci`, `noal`, `sial`, `alb`, `noH`, `siH`, `descripcion`) VALUES ( '$estudio', '$fechaActual', '$cedulaMedico','$nombreMedico', '$ciudad', '$codigoPaciente', '$siI', '$noI', '$siE', '$noE','$fem', '$mas','$peso', '$talla', '$sistolica', '$diastolica', '$nocol','$sicol','$colesterol','$nocolh','$sicolh','$colesterolh','$notri','$sitri','$trigli', '$nogli', '$sigli', '$gli','$nohe','$sihe','$hemo','$nocre','$sicre', '$cre','$noac','$siac', '$aci', '$noal','$sial','$alb','$noH','$siH','$descripcion')";
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
            $nocol1 = $row['nocol'];
            $sicol1 = $row['sicol'];
            $colesterol1 = $row['colesterol'];
            $nocolh1 = $row['nocolh'];
            $sicolh1 = $row['sicolh'];
            $colesterolh1 = $row['colesterolh'];
            $notri1 = $row['notri'];
            $sitri1 = $row['sitri'];
            $trigli1 = $row['trigli'];
            $nogli1 = $row['nogli'];
            $sigli1 = $row['sigli'];
            $gli1 = $row['gli'];
            $nohe1 = $row['nohe'];
            $sihe1 = $row['sihe'];
            $hemo1 = $row['hemo'];
            $nocre1 = $row['nocre'];
            $sicre1 = $row['sicre'];
            $cre1 = $row['cre'];
            $noac1 = $row['noac'];
            $siac1 = $row['siac'];
            $aci1 = $row['aci'];
            $sial1 = $row['sial'];
            $noal1 = $row['noal'];
            $alb1 = $row['alb'];
            $noH1 = $row['noH'];
            $siH1 = $row['siH'];
            $descripcion1 = $row['descripcion'];
        }
        
        
        class PDF extends FPDF
            {
                // Cabecera de página
                function Header()
                    {
                        $this->Image('Chaco.PNG','6','6','200','242', 'PNG');
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
            $pdf->SetXY(27,70);
            $pdf->MultiCell(200, 20, utf8_decode($fechaActual1), 0, 'L', 0);
            $pdf->SetXY(60,70);
            $pdf->MultiCell(200, 20, utf8_decode($nombreMedico1), 0, 'L', 0);
            $pdf->SetXY(125,70);
            $pdf->MultiCell(200, 20, utf8_decode($ciudad1), 0, 'L', 0);
            $pdf->SetXY(179,70);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($codigoPaciente1), 0, 'L', 0);
            $pdf->SetXY(40,110);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(200, 20, utf8_decode($siL1), 0, 'L', 0);
            $pdf->SetXY(40,110);
            $pdf->MultiCell(200, 20, utf8_decode($noL1), 0, 'L', 0);
            $pdf->SetXY(120,114);
            $pdf->MultiCell(200, 20, utf8_decode($siE1), 0, 'L', 0);
            $pdf->SetXY(120,114);
            $pdf->MultiCell(200, 20, utf8_decode($noE1), 0, 'L', 0);  
            $pdf->SetXY(30,147);
            $pdf->MultiCell(200, 20, utf8_decode($fem1), 0, 'L', 0);
            $pdf->SetXY(30,147);
            $pdf->MultiCell(200, 20, utf8_decode($mas1), 0, 'L', 0);
            $pdf->SetXY(104,150);
            $pdf->MultiCell(200, 20, utf8_decode($peso1), 0, 'L', 0);
            $pdf->SetXY(104,159);
            $pdf->MultiCell(200, 20, utf8_decode($talla1), 0, 'L', 0);
            $pdf->SetXY(160,150);
            $pdf->MultiCell(200, 20, utf8_decode($sistolica1), 0, 'L', 0);
            $pdf->SetXY(160,156);
            $pdf->MultiCell(200, 20, utf8_decode($diastolica1), 0, 'L', 0);
            $pdf->SetXY(30,190);
            $pdf->MultiCell(200, 20, utf8_decode($nocol1), 0, 'L', 0);
            $pdf->SetXY(40,190);
            $pdf->MultiCell(200, 20, utf8_decode($sicol1), 0, 'L', 0);
            $pdf->SetXY(61,190);
            $pdf->MultiCell(200, 20, utf8_decode("$colesterol1"), 0, 'L', 0);
            $pdf->SetXY(110,190);
            $pdf->MultiCell(200, 20, utf8_decode($nocolh1), 0, 'L', 0);
            $pdf->SetXY(115,190);
            $pdf->MultiCell(200, 20, utf8_decode($sicolh1), 0, 'L', 0);
            $pdf->SetXY(140,190);
            $pdf->MultiCell(200, 20, utf8_decode($colesterolh1), 0, 'L', 0);
            $pdf->SetXY(30,198);
            $pdf->MultiCell(200, 20, utf8_decode($notri1), 0, 'L', 0);
            $pdf->SetXY(40,198);
            $pdf->MultiCell(200, 20, utf8_decode($sitri1), 0, 'L', 0);
            $pdf->SetXY(61,198);
            $pdf->MultiCell(200, 20, utf8_decode($trigli1), 0, 'L', 0);
            $pdf->SetXY(110,198);
            $pdf->MultiCell(200, 20, utf8_decode($nogli1), 0, 'L', 0);
            $pdf->SetXY(118,198);
            $pdf->MultiCell(200, 20, utf8_decode($sigli1), 0, 'L', 0);
            $pdf->SetXY(128,198);
            $pdf->MultiCell(200, 20, utf8_decode($gli1), 0, 'L', 0);
            $pdf->SetXY(30,206);
            $pdf->MultiCell(200, 20, utf8_decode($nohe1), 0, 'L', 0);
            $pdf->SetXY(40,206);
            $pdf->MultiCell(200, 20, utf8_decode($sihe1), 0, 'L', 0);
            $pdf->SetXY(61,206);
            $pdf->MultiCell(200, 20, utf8_decode($hemo1), 0, 'L', 0);
            $pdf->SetXY(110,206);
            $pdf->MultiCell(200, 20, utf8_decode($nocre1), 0, 'L', 0);
            $pdf->SetXY(118,206);
            $pdf->MultiCell(200, 20, utf8_decode($sicre1), 0, 'L', 0);
            $pdf->SetXY(125,206);
            $pdf->MultiCell(200, 20, utf8_decode($cre1), 0, 'L', 0);
            $pdf->SetXY(30,215);
            $pdf->MultiCell(200, 20, utf8_decode($noac1), 0, 'L', 0);
            $pdf->SetXY(40,215);
            $pdf->MultiCell(200, 20, utf8_decode($siac1), 0, 'L', 0);
            $pdf->SetXY(61,215);
            $pdf->MultiCell(200, 20, utf8_decode($aci1), 0, 'L', 0);
            $pdf->SetXY(110,215);
            $pdf->MultiCell(200, 20, utf8_decode($noal1), 0, 'L', 0);
            $pdf->SetXY(118,215);
            $pdf->MultiCell(200, 20, utf8_decode($sial1), 0, 'L', 0);
            $pdf->SetXY(125,215);
            $pdf->MultiCell(200, 20, utf8_decode($alb1), 0, 'L', 0);
            $pdf->SetXY(30,225);
            $pdf->MultiCell(200, 20, utf8_decode($noH1), 0, 'L', 0);
            $pdf->SetXY(30,225);
            $pdf->MultiCell(200, 20, utf8_decode($siH1), 0, 'L', 0);
            if($siH1 == "Si")
            {
                $pdf->SetXY(30,230);
                $pdf->MultiCell(200, 20, utf8_decode("Descripción:"), 0, 'L', 0);
                $pdf->SetXY(48,230);
                $pdf->MultiCell(200, 20, utf8_decode($descripcion1), 0, 'L', 0);
            }
            else
            {   
                $pdf->SetXY(30,236);
                $pdf->MultiCell(200, 20, utf8_decode("Descripción:"), 0, 'L', 0);
                $pdf->SetXY(48,236);
                $pdf->MultiCell(200, 20, utf8_decode("No aplica"), 0, 'L', 0);
                
            }
            $pdf ->SetFont('Arial','',4);
            $pdf->SetXY(10,245);
            $pdf ->MultiCell(0,4,utf8_encode("Certifico que tengo conocimiento que mi usuario y contrasena empleados para el diligenciamiento del presente formato y/o archivo son de uso absolutamente personal e intransferible y que he cumplido con los protocolos de seguridad. Al completar el diligenciamiento del presente formato y/o archivo, entiendo, autorizo y certifico su equivalencia con la firma autografa para todos los efectos eticos y legales. Igualmente certifico que la informacion aqui consignada ha sido tomada de los datos de la historia clinica del paciente."), 'I', 'J',0);
            $pdf->SetXY(97,251);
            $pdf ->MultiCell(0,4,utf8_decode(FIRMA), 'I', 'J',0);
            $pdf->SetXY(95,253);
            $pdf ->MultiCell(0,4,utf8_decode($cedulaingresada), 'I', 'J',0);
            $pdf->SetXY(87,255);
            $pdf ->MultiCell(0,4,utf8_decode($nombreMedico1), 'I', 'J',0);
            
            
            
            
             $bd= mysqli_connect('localhost', 'scandapp_app', 'Qwerty1234$', 'scandapp_app');
                    $ubicacion = "documento/doc_Chaco".time().".pdf";
                    $content = $pdf->Output($ubicacion, "F"); 
                    $sql="UPDATE formulariochaco SET archivo = '$ubicacion' WHERE id_formularioc =".$id1;
                    $query=mysqli_query($bd, $sql);
                    
                    $querya ="UPDATE pacientes SET habilitado = '0' WHERE codigoPaciente = '$codigoPaciente'";
                    
                    $ejecutar = mysqli_query($bd, $querya);
                    var_dump(mysqli_error($bd));
                    header('Location: index3.php?id='.$id1);
?>