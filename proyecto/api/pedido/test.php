<nav class="menu">
                <ul>
                 <!-- ACCEDER -->
                   <?php
                     if(isset($_GET['acce']) && $_GET['acce']=="1"){
                   ?>
                        <li><a href="../index.php" onload="acceder();" class="acceder">ACCEDER</a></li>

                   <?php
                     }else {
                   ?>
                        <li><a class="acceder">ACCEDER</a></li>
                   <?php
                     }
                    ?>
                  <li><a href="php/acercaDe.php">ACERDA DE</a></li>
                </ul>
              </nav>
<script>
  $(document).ready(function(){
      $('.acceder').click(function(){
        $('.all-paquetes').addClass('all-paquetesDesplasarFuera');
        $('.acceder-cont').addClass('acceder-cont-visual');
      });
      $('.flecha').click(function(){
        $('.acceder-cont').removeClass('acceder-cont-visual');
        $('.registro-cont').removeClass('registro-cont-visual');
        $('.all-paquetes').removeClass('all-paquetesDesplasarFuera');
        });
        $('.registrarme').click(function(){
          $('.acceder-cont').removeClass('acceder-cont-visual');
          $('.registro-cont').addClass('registro-cont-visual');

        window.onload=function acceder(){
          alert("mensaje");
          // $('.all-paquetes').addClass('all-paquetesDesplasarFuera');
          // $('.acceder-cont').addClass('acceder-cont-visual');
        }

        });
    
</script>