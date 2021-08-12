<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');

             function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }

if (isset($_GET['id']) AND $_GET['id'] >0 ) {
	$getid = intval($_GET['id']);
}
include('business_query.php');

?>

<html>
     <head>
     	<title><?php echo $vendeur['nom']; ?></title>
     	 <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta http-equiv="X-UA-Compatibility" content="ie=edge">
         
         <link rel="stylesheet" href="aos-master02/dist/aos.css" />
     </head>
     <body>
     	<?php 
           include('css/business.php');
         ?>
         <?php
           include("header.php"); 
           include('saved_product_navbar.php'); 
         ?>    
            <div class="panels"> 
               <div class="infos">
                  <div class="profil_pic"><div><?php echo $vendeur['nom']; ?></div></div> 
                  <div style="width: 100%; font-size: 1.1vw;margin-top: 2vw;">
                        <div class="s_infos" > Numero de telephone: <?php echo $vendeur['numero']; ?></div>
                        <div class="s_infos" > adresse mail: <?php echo $vendeur['email']; ?></div>
                        <div class="s_infos" > site Web: <?php echo $vendeur['site_web']; ?></div>
                        <div class="s_infos" > Descrption: <br><p><?php echo $vendeur['description']; ?></p></div>
                  </div>
                   <?php if (isset($_SESSION['id']) AND $_SESSION['id'] == $vendeur['id_membre']) {
                       ?>
                        <a href="business.php?id=<?php echo $_GET['id']; ?>" style="width: 30%; height: 7vh;"><div class="button">modifier les infos</div></a><br>
                       <?php
                       } ?>
                 
               </div>
   
               <div class="produits">
                  <span class="titres">Produit(s)</span>
                  <div class="list_produits">
                      <?php
                      if (isset($_GET['page']) AND $_GET['page'] > 1) {
                          $count= (($_GET['page']-1)*7);
                          $max_display=(($_GET['page'])*7);
                          $page=$_GET['page'] ;
                      }else{
                          $count= 0;
                          $max_display=7;
                          $page=1;
                      }

                        
                        while ($count < $max_display) {
                            if (isset($produits[$count])) {
                      ?>
                  <a href="Produit.php?id=<?php echo($produits[$count]['id']); ?>">
                 <div class="option">
                     <div style="height: 100%; width:15%; background-image: url('img/product_pics/<?php echo($produits[$count]['id']); ?>.jpg');background-size: cover; background-position: center; border-radius: 10px;
                     <?php if (isMobile()) {
                       ?>
                         width:25%;
                       <?php
                       }?>"></div>
                      <table  <?php if (isset($_SESSION['id']) AND $_SESSION['id'] == $vendeur['id_membre']) {
                       ?>
                         width="60%" 
                       <?php
                       }else{if (isMobile()) { ?>
                         width="75%"
                        <?php }else{ ?>
                         width="85%"
                       <?php
                       }}?> style="text-align: left; padding: 0.5vw; margin: auto 0px;" >
                        <tr>                
                           <td <?php if (!isMobile()) {
                       ?>
                        width="30%" style="font-size: calc(3px + 2vw);"
                       <?php
                       }else{?>
                        width="35%" style="font-size: calc(3px + 2vw);"
                        <?php
                       }?>>
                       <?php echo $produits[$count]['prix']." FCFA"; ?></td>
                           <td style="font-size: calc(6px + 1.5vw);<?php if (isMobile()) {
                       ?>
                       font-size: calc(6px + 2vw);
                       <?php
                       }?>"> <b><?php echo $produits[$count]['nom']; ?></b></td>              
                        </tr>
                        <tr>
                          <td colspan="2"><?php echo $produits[$count]['description']; ?> </td>
                        </tr>
                      </table> 
                 </div>
               </a>
                      <?php
                           } $count++;
                        }

                      ?>
                  </div>
                  <div style="display: flex; flex-wrap: wrap; width: 100%;">
                    <?php if (isset($_SESSION['id']) AND $_SESSION['id'] == $vendeur['id_membre']) {
                       ?>
                        <a href="" style="width: 30%;"><div class="button">Ajouter un Produit</div></a>
                       <?php
                       } ?>
                     
                      <?php

                       if ( $page > 1) {
                      ?> 
                      <a href="business.php?id=<?php echo $_GET['id'].'&page='.($page-1); ?>" style="width: 24%;"><div class="button"><< Précédent</div></a>
                      <?php
                       }
                      
                       if ( $max_display < $num_produit) {
                      ?> 
                     <a href="business.php?id=<?php echo $_GET['id'].'&page='.($page+1); ?>" style="width: 24%;"><div class="button">Suivant >></div></a>
                      <?php
                       }
                      ?>
                  </div>
               </div>
               <br>
               <div class="produits_vendu">
                   
               </div>
   
              
        </div>
         <?php include('footer.php'); ?>   
     </body>
</html>