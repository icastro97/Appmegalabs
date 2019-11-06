<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/responsive.css">

<?php


 require_once("seguridad/config.php");
 require('mcv5/clases/DB.class.php');
 
 if (!isset($_SESSION["access"])) {

    try {
         $sql = "SELECT  mod_modulegroupcode, mod_modulegroupname FROM module    GROUP BY  mod_modulegroupcode, mod_modulegroupname  ORDER BY  mod_modulegroupcode, mod_modulegroupname";

        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $commonModules = $stmt->fetchAll();

          $sql = "SELECT icon, mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename FROM module "
                . " WHERE 1 "
                . " ORDER BY `mod_modulegrouporder` ASC, `mod_moduleorder` ASC  ";
                
        
        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $allModules = $stmt->fetchAll();

        $sql = "SELECT rr_modulecode, rr_create,  rr_edit, rr_delete, rr_view FROM role_rights "
                . " WHERE  rr_rolecode = :rc "
                . " ORDER BY `rr_modulecode` ASC  ";

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rc", $_SESSION["rolecode"]);
        
        
        $stmt->execute();
        $userRights = $stmt->fetchAll();

        $_SESSION["access"] = set_rights($allModules, $userRights, $commonModules);
		//echo "valor sesion " . $_SESSION["access"];


    } catch (Exception $ex) {

        echo $ex->getMessage();
    }
}

?>
<?php require_once("cabeza.php");?>
 <img src="assets/img/app/favoritos.png">
 
 <br>
<br>

 <?php foreach ($_SESSION["access"] as $key => $access) { ?>
                         
                           <div class="caja">
                            <!--<a href="javascript:;"agrupa >-->
                            <a href="default1.php?group=<?php echo $access["top_menu_name"]; ?>" class="resp"  >
                                 <div id="estilo" class="resp1">
                                    <div align="right" id="modulos">
                                      <img src="assets/img/app/search.png" alt="<?php echo $access["top_menu_name"]; ?>"  ><br><?php echo $access["top_menu_name"]; ?>
                                    </div>
                                </div>
                            </a>
                            </div>
                           
                      
                        <?php
                    }
                    ?>


 
 
<?php
require_once("pie.php");
?>
