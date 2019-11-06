<?php

require_once '../mcv5/clases/DB.class.php'; 
require('consultas.php');
require('fpdf/fpdf.php');
require ('phpmailer/class.phpmailer.php');

    $titulo = $_POST['titulo'];
    $fechaActual = $_POST['fechaActual'];    
    $fechaSiguiente = $_POST['fechasiguiente'];
    $descripcion = $_POST['descripcion'];
    $comentario = $_POST['comentario'];
    if(!is_dir("uploads/"))
    mkdir("uploads/", 0777);
    $file = $_FILES["file"];
    $nombre = time() . $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = 0;//getimagesize($ruta_provisional);
    $width = 0;//$dimensiones[0];
    $height = 0;//$dimensiones[1];
    $carpeta = "uploads/";
    $src = $carpeta . $nombre;
    move_uploaded_file($ruta_provisional, $src);   
    
    $insertar = insertarDatos($titulo, $fechaActual, $fechaSiguiente, $descripcion, $comentario, $nombre);
        
    $s = mysqli_insert_id($mysqli);

    class PDF extends FPDF
     {
         
         function Header()
             {
                global $fechaActual;
             $this->Image('fondo.jpg','-5','1','240','284', 'JPG');
             $this->SetFont('Arial','B',10);
             $this->SetXY(110,20);
             $this->Ln(25);
             $this->Write(2, "Fecha: $fechaActual");
             }
                            
    
            
    
     }
    
     $pdf = new PDF('P','mm','Letter');    
     $pdf->SetTitle('Denuncia');
     $pdf->AliasNbPages();
     $pdf->SetTopMargin(30);
     $pdf -> addPage();

    
    
     $pdf -> Ln(10);
     $pdf->SetXY(110,20);

    
    
    
    
     $pdf -> Ln(10);
    
    
     $pdf ->SetFont('Arial','I',9);
     $pdf -> Ln(30);
     $pdf ->SetFont('Arial','B',12);
     $pdf->Cell(200,5,utf8_decode('Consecutivo: '.$s),0,0,'L',0);
     $pdf -> Ln(5);
     $pdf ->SetFont('Arial','B',10);
     $pdf ->MultiCell(0,4,utf8_decode(''), 0, 'C',0);
     $pdf -> Ln(5);
     $pdf ->SetFont('Arial','',20);
     $pdf->Cell(200,20,utf8_decode(''.strtoupper($titulo)),0,0,'C',0);
     $pdf -> Ln(25);
     $pdf ->SetFont('Arial','',10);
     $pdf ->MultiCell(0,4,utf8_decode("La fecha en la que se presento el incidente: "), 'I', 'L',0);     
     $pdf ->SetFont('Arial','B',10); 
     $pdf ->MultiCell(0,-4,utf8_decode($fechaSiguiente), 0, 'C',0);
     $pdf -> Ln(15);   
     $pdf->SetFont('Arial', '', 10);  
     $pdf ->MultiCell(0,4,utf8_decode("Descripci贸n del incidente:   $descripcion"), 'I', 'J',0);
     $pdf -> Ln(15);
     $pdf ->MultiCell(0,4,utf8_decode("Comentarios:   $comentario"), 'I', 'J',0);
     $pdf -> Ln(4);
     $pdf ->MultiCell(0,4,utf8_decode(""), 'I', 'L',0);
     $pdf ->MultiCell(0,4,utf8_decode(""), 0, 'L',0);
     $ubicacion = "documento/".$s."-".strtoupper($titulo).".pdf";
     $content = $pdf->Output($ubicacion, "F"); 
     $sql="UPDATE formulario_denuncia  SET pdf = '$ubicacion' WHERE id=". $s;
     $query=mysqli_query($mysqli, $sql);        
     
    $mail = new PHPMailer();
    
    //Luego tenemos que iniciar la validación por SMTP:
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "mail.appmegalabs.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = "aplicativos@appmegalabs.com"; // Correo completo a utilizar
    $mail->Password = "SebastiaN123"; // Contraseña
    $mail->Port = 587; // Puerto a utilizar
    
    //Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
    $mail->From = "aplicativos@appmegalabs.com"; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "Administrador";
    
    //Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
    $mail->AddAddress("compliance@scandinavia.com.co"); // Esta es la dirección a donde enviamos
    $mail->AddAddress("juansebastian.condefarias@gmail.com"); // Esta es la dirección a donde enviamos
    $mail->AddAddress("lgalindo@scandinavia.com.co"); // Esta es la dirección a donde enviamos
    
    $mail->IsHTML(true); // El correo se envía como HTML
    $asunto = "DENUNCIA";
    $mail->Subject = utf8_decode($asunto); // Este es el titulo del email.
    $body = "Denuncia reportada desde el canal etico de denuncias.";
    $mail->Body = $body; // Mensaje a enviar
    $mail->AddStringAttachment(file_get_contents($ubicacion),$s.'-'.$titulo.'.pdf', 'base64', 'application/pdf');
    $exito = $mail->Send(); // Envía el correo.
    
    //También podríamos agregar simples verificaciones para saber si se envió:
    if($exito){
    header('Location:respuesta.php');
    }else{
    header('Location:rechazo.php');
    }

       
?>