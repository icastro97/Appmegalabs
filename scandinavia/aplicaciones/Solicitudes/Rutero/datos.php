<?php

class dato
{

    public $fechaActual;
    public $descripcion;
    public $direccion;
    public $diligencia;
	public $uno;
	public $dos;
    
    public function registrarDato($fechaActual, $descripcion, $direccion, $diligencia, $uno, $dos)
    {
        include('bd.php');
        
		$resultado = mysqli_query ($bd,"INSERT INTO datos(fechaActual, descripcion,direccion, fechaDiligenciada, jornadaM, jornadaN) VALUES ('$fechaActual','$descripcion','$direccion','$diligencia',' $uno','$dos')");
	
		if($resultado)
		 {
		 		echo "Sus datos han sido registrados.";
					
			 
		 }
		 else
		 {
				echo "No se pudo registrar";
						
			 
		 }
			 
		mysqli_close($bd);
                         
    }
}
?>