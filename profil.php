<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');
 
  if(!isset($_SESSION['id'])){
      header("Location: inscription.php");
    }else {
       if (isset($_GET['id']) AND $_GET['id'] >0 ) {
            $getid = intval($_GET['id']);  
            if ($getid != $_SESSION['id']) {
                 header("Location: profil.php?id=".$_SESSION['id']); 
             } 
         }else{
              header("Location: profil.php?id=".$_SESSION['id']); 
         }

    } 
 
 function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }
/* fetch the user info */
       $requser = $bdd->prepare("SELECT * FROM membres WHERE id=?");
       $requser->execute(array($getid));
       $userinfo = $requser->fetch();
/* fetch the user commands*/
       $reqsaved = $bdd->prepare("SELECT * FROM `produits_enregistre` WHERE `id_membres` = ? ORDER BY `date` DESC"); 
        $reqcommands = $bdd->prepare("SELECT * FROM `commandes` WHERE `id` = ? ORDER BY `date_d'achat` DESC WHERE ` statut` = 'en attente'");
        $reqbought = $bdd->prepare("SELECT * FROM `commandes` WHERE `id` = ? ORDER BY `date_d'achat` DESC WHERE ` statut` = 'livre'"); 
        $reqbussiness = $bdd->prepare("SELECT * FROM `membres_vendeurs` WHERE `id` = ?");                
        $reqlivreur = $bdd->prepare("SELECT * FROM `livreurs` WHERE `id` = ?");               
        $reqpdl = $bdd->prepare("SELECT * FROM `point_de_livraison` WHERE `id` = ?");
        
        $reqsaved->execute(array($_SESSION['id'])); 
        $reqcommands->execute(array($_SESSION['id']));
        $reqbought->execute(array($_SESSION['id'])); 
        $reqbussiness->execute(array($_SESSION['id']));
        $reqlivreur->execute(array($_SESSION['id']));
        $reqpdl->execute(array($_SESSION['id']));
      
         
       
       
        $pdl = $reqpdl->fetch();
       $bus = $reqbussiness->fetch();
       $liv = $reqlivreur->fetch();
       $number_of_displayed_choice = 3;

       include('css/profil.php');
?>

<html>
     <head>
     	<title><?php echo $userinfo['nom'];?></title>
     	 <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta http-equiv="X-UA-Compatibility" content="ie=edge">
         
         <link rel="stylesheet" href="aos-master02/dist/aos.css" />
     </head>
     <body>
     	<script type="text/javascript">
      var boughtProductsArray = [];
      </script>
         <?php
           include("header.php"); 
         ?>
         <div class="profilpic" >
            <h1><?php echo $userinfo['nom'];?></h1>
         </div>


  <?php 
     if (!isset($_GET['subpage'])) {
  ?>
    
        <div class="panels"> 

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// !-->

            <div class="Savedproducts" >
              <?php  $number=$reqsaved->rowCount(); ?>
                <h2 class="titre">En attente d'achat  (<?php echo $number; ?>)</h2>
               <a href="profil.php?id=1&subpage=saved">
                <div class="sub_savedproducts" >
                   <?php 
                        
                         if ( $number > 0) { 
                           
                          $count=0;  while ($saved=$reqsaved->fetch() AND $count <  $number_of_displayed_choice) { 
                           $req_produits_saved = $bdd->prepare("SELECT * FROM `produits` WHERE `id` = ?"); 
                           $req_produits_saved->execute(array($saved["id_produit"]));
                           $produits_saved =$req_produits_saved->fetch(); 
                   ?>
                     <script type="text/javascript">
                       boughtProductsArray[<?php echo $count; ?>] = <?php echo($produits_saved['id']); ?>
                     </script>                                        
                   <img class="saved_img" height="100%" src="img/product_pics/<?php echo($produits_saved['id']); ?>.jpg"> 
                   <?php $count++; }  ?> 
                       <img class="saved_img" height="100%" src="img/plus.png">
                     <br>

                   <?php }else if ($number < 1) {?> 
                      <div> Tu n'a pas encore enregistrer de produits...</div><br>
                   <?php }?>
                </div></a>
                  <br><div id="buySaved"></div><div class="button" style="width: 45%;"> <a href="produits_services.php" >Produits et Services</a></div><br>
            </div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// !-->

            <div class="businessPage">
               <h2 class="titre">Vos Pages Business Eden</h2>
               <?php
                   if (isset($bus['id'])) {
               ?>
                 <a href="business.php?id=<?php echo $bus['id']; ?>"><div class="s_business"><div style="background-image: url('img/business_profil_pics/<?php echo($bus['id'])?>.jpg');" class="s_business_img"></div> <?php echo $bus["nom"]; ?></div>       
                <?php
                   }else{
                    ?>
                 <a href="createbusiness.php?type=1"><div class="s_business"><div style="background-image: url('img/plus.png');" class="s_business_img"></div> Creez votre compte business</div> </a>
                    <?php
                   }
                    if (isset($liv['id'])) {
               ?> 
                 <div class="s_business"><div style=" background-image: url('img/livreur_profil_pics/<?php echo($liv['id'])?>.jpg');" class="s_business_img"></div> <?php echo $liv["nom"]; ?> </div> 
                 <?php
                  }else{
                    ?>
                 <a href="createbusiness.php?type=2"><div class="s_business"><div style=" background-image: url('img/plus.png');" class="s_business_img"></div> Creez votre compte Livreur</div> </a>
                    <?php
                   }
                    if (isset($pdl['id'])) {
               ?>     
                 <div class="s_business"><div style=" background-image: url('img/pdl_profil_pics/<?php echo($pdl['id'])?>.jpg');" class="s_business_img"></div> <?php echo $pdl["nom"]; ?> </div>            
                  
                  <?php
                   }else{
                    ?>
                 <a href="createbusiness.php?type=3"><div class="s_business" style="text-align: left;"><div style=" background-image: url('img/plus.png');" class="s_business_img"></div> Creez votre compte Point de Livraisaon</div> </a>
                    <?php
                   }
               ?> 
            </div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// !-->


            <div class="commands">
              <?php  $number=$reqcommands->rowCount(); ?>
               <h2 class="titre">En attente de Livraison  (<?php echo $number; ?>)</h2> 
                <div class="sub_savedproducts">
                   <?php 
                        
                         if ( $number > 0) { 
                           
                          $count=0;  while ($commands=$reqcommands->fetch() AND $count <  $number_of_displayed_choice) { 
                           $req_produits_command = $bdd->prepare("SELECT * FROM `produits` WHERE `id` = ?"); 
                           $req_produits_command->execute(array($commands["id_produit"]));
                           $produits_command =$req_produits_command->fetch(); 
                   ?>
                        
                    <img style="border-radius: 10%;width : 48%;height: 15vw;margin: 1px;" height="100%" src="img/product_pics/<?php echo($produits_command['id']); ?>.jpg"> 
                   <?php $count++; }  ?> 
                       <img style="border-radius: 10%;width : 48%;height: 15vw;margin: 1px;" height="100%" src="img/plus.png">
                     <br>

                   <?php }else if ($number < 1) {?> 
                      <div> Tu n'a pas encore enregistrer de produits...</div><br>
                   <?php }?>
                </div>
                  <br><div class="button" style="width: 45%;"> <a href="produits_services.php" >Produits et Services</a></div><br>
            </div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// !-->

            <div class="boughtproducts">
              <?php   $number=$reqbought->rowCount();  ?>
                <h2 class="titre">Historique (<?php echo $number; ?>)</h2> 
                <div class="sub_savedproducts">
                   <?php 
                        
                         if ( $number > 0) { 
                           
                          $count=0;  while ($boughtproducts=$reqbought->fetch() AND $count <  $number_of_displayed_choice) { 
                           $req_produits_bought = $bdd->prepare("SELECT * FROM `produits` WHERE `id` = ?"); 
                           $req_produits_bought->execute(array($boughtproducts["id_produit"]));
                           $produits_bought =$req_produits_bought->fetch(); 
                   ?>
                        
                    <img style="border-radius: 10%;width : 48%;height: 15vw;margin: 1px;" height="100%" src="img/product_pics/<?php echo($produits_bought['id']); ?>.jpg"> 
                   <?php $count++; }  ?> 
                       <img style="border-radius: 10%;width : 48%;height: 15vw;margin: 1px;" height="100%" src="img/plus.png">
                     <br>

                   <?php }else if ($number < 1) {?> 
                      <div> Tu n'a pas encore enregistrer de produits...</div><br>
                   <?php }?>
                </div>
                  <br><div class="button" style="width: 45%;"> <a href="produits_services.php" >Produits et Services</a></div><br>
            </div>
        </div>  
  <?php 
}else if ($_GET['subpage'] == "saved") {
      include("p_savedproducts.php");
 ?>


  <?php 
}else if ($_GET['subpage'] == "waiting") {
      include("p_commandedproducts.php");
 ?>


  <?php 
}else if ($_GET['subpage'] == "bought") {
      include("p_boughtproducts.php");
 ?>


  <?php 
}
  ?>
  

     <?php
           include("footer.php"); 
    ?>
    <script type="text/javascript">

       boughtProductsArray.forEach(setSavedButtons);
       function setSavedButtons(value){
        document.getElementById('Savedproducts'+value).addEventListener('click',function(){
          if (document.getElementById('Savedproductsimg'+value).style.getPropertyValue('z-index') < 0) {
            document.getElementById('Savedproductsimg'+value).style.setProperty('z-index',10);
          } else if (document.getElementById('Savedproductsimg'+value).style.getPropertyValue('z-index') > 0){
            document.getElementById('Savedproductsimg'+value).style.setProperty('z-index',-10);
          }
          
        });
       }
      
    </script>
     </body>
</html>