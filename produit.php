<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');

 function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }
      if (!isset($_GET['id']) OR $_GET['id'] == "") {
      	    header("Location: produits.php");  
      }
      
      include('produit_query.php');  

/////////////////////////////////////////////////////////////////////////////////////// Ajouter au Panier /////////////////////////////////     
      if (isset($_POST['panier']) AND $_POST['panier']=="Ajouter au Panier") {

        $prix_totale = 0;
        $temp_produits = [];
         $temp_vendeurs = [];
        if (isset($_SESSION['vendeur'])) {
          $cook = $_SESSION['vendeur'];
            if (isset($cook[$vendeur['id']])) {    
                  $temp_produits = $cook[$vendeur['id']]['produits'];
                  foreach ($temp_produits as $key) {
                    $prix_totale += $key['prix'];
                  }
            }else{
               
             
            }
            $temp_vendeurs = $cook;
        }else{         
          
        }
        $ces_variantes = [];
         $count2 = 0; 
                      $count3 = 1;   
                  while ($count2 < $max_number_variante) { 
                       $corresponding_variante = [];   
                       foreach ($variante as $key ) {
                                if ($key['id_variante'] == $count2) {
                                  array_push($corresponding_variante, $key);
                                }
                              }
                            
                  if (count($corresponding_variante) != 0) {
                    if (isset($_POST[$corresponding_variante[0]['id_variante']])) {
                      $req_nom_sous_variante= $bdd->prepare("SELECT nom FROM sous_variante WHERE id=?");
                       $req_nom_sous_variante->execute(array($_POST[$corresponding_variante[0]['id_variante']]));
                       $nom_sous_variante = $req_nom_sous_variante->fetch();

                     array_push($ces_variantes,array('id_variante'=>$corresponding_variante[0]['id_variante'], 'id_sous_variante'=>$_POST[$corresponding_variante[0]['id_variante']], 'nom_sous_variante'=> $nom_sous_variante ));
                    }else{
                      $_POST['error'] = "Veillez Selectioner une option sous ".$corresponding_variante[0]['nom_variante'];
                      $_POST['panier'] = "x";
                      header("produit.php?id=".$_GET['id']);

                    }
                      
                     
                    }
                    $count2++;
              }
              if ($_POST['panier'] != "x") {
                 $ce_produit =["id_produit"=>$produit['id'],"nom_produit"=>$produit['nom'],"variante"=> $ces_variantes,"prix"=>$produit['prix']];
        $prix_totale += $ce_produit['prix'];
        array_push($temp_produits, $ce_produit);
        $ce_vendeur = ['nom_vendeur'=>$vendeur['nom'],'produits'=>$temp_produits,'prix_totale' => $prix_totale];
        $temp_vendeurs[$vendeur['id']] = $ce_vendeur;
        $_SESSION['vendeur'] =  $temp_vendeurs;
        $_POST['panier'] = "x";
              }
       
      }

/////////////////////////////////////////////////////////////////////////////////////// Ajouter au Panier /////////////////////////////////     
      if (isset($_POST['rpanier']) AND $_POST['rpanier']=="Retirer du Panier") {

        $prix_totale = 0;
        $temp_produits = [];
         $temp_vendeurs = [];
        if (isset($_SESSION['vendeur'])) {
          $cook = $_SESSION['vendeur'];
            if (isset($cook[$vendeur['id']])) {    
                  $temp_produits = $cook[$vendeur['id']]['produits'];
                  foreach ($temp_produits as $key) {
                    $prix_totale += $key['prix'];
                  }
            }else{
               
             
            }
            $temp_vendeurs = $cook;
        }else{         
          
        }
        $ces_variantes = [];
         $count2 = 0; 
                      $count3 = 1;   
                  while ($count2 < $max_number_variante) { 
                       $corresponding_variante = [];   
                       foreach ($variante as $key ) {
                                if ($key['id_variante'] == $count2) {
                                  array_push($corresponding_variante, $key);
                                }
                              }
                            
                  if (count($corresponding_variante) != 0) {
                       if (isset($_POST[$corresponding_variante[0]['id_variante']])) {
                        array_push($ces_variantes,array('id_variante'=>$corresponding_variante[0]['id_variante'], 'id_sous_variante'=>$_POST[$corresponding_variante[0]['id_variante']]));
                       }else{
                         $_POST['error'] = "Veillez Selectioner une option sous ".$corresponding_variante[0]['nom_variante'];
                         $_POST['rpanier'] = "x";
                         header("produit.php?id=".$_GET['id']);

                       }                         
                    }
                    $count2++;
              }
              if ($_POST['rpanier'] != "x") {
                
                 $ce_produit =["id_produit"=>$produit['id'],"nom_produit"=>$produit['nom'],"variante"=> $ces_variantes,"prix"=>$produit['prix']];
                   if ($temp_produits != []) {
                      
                       $count =0;
                       while ($count < count($temp_produits)) {
                        
                          if ($temp_produits[$count]['id_produit'] == $ce_produit['id_produit']) {
                           $is_ok=1;
                                foreach ($ce_produit['variante'] as $key) {
                                  if (!in_array($key, $temp_produits[$count]['variante'])) {
                                    $is_ok=0;
                                  }
                                }
                                if ($is_ok=1) {
                                 
                               
                             array_splice($temp_produits, $count,1);
                              $prix_totale -= $ce_produit['prix'];
                              $ce_vendeur = ['nom_vendeur'=>$vendeur['nom'],'produits'=>$temp_produits,'prix_totale' => $prix_totale];
                             $temp_vendeurs[$vendeur['id']] = $ce_vendeur;
                             $_SESSION['vendeur'] =  $temp_vendeurs;
                             
                             $count+=10000000000;
                              }
                           }else{
                             $_POST['error'] = "Vous n'avez pas ce produit dans votre panier.";
                           }
                          $count++;
                       }
                 }else{
                   $_POST['error'] = "Vous n'avez pas de produit dans votre panier.";
                 }
                $_POST['rpanier'] = "x";
              }
       
      }
      if (isset($_POST['error'])) {
       echo $_POST['error'];
      }
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $produit['nom']; ?></title>
</head>
<body>
   <?php 
   include('header_produit.php'); 
    
     include('css/produit.php');  
     include('saved_product_navbar.php');  
   ?>

    <?php if(isMobile()){ ?>
   <div style="display: flex ;margin: 1vh 0px 0vh 0px;background-color: rgba(255,255,255,0.6);width: 100%;padding: 5px;">
     
      <a href="business.php?id=<?php echo $vendeur['id'].'&page=1'; ?>" style="height: 100%; width: 100%;"><div class="profil" style="margin: 1% auto 3% auto;"><div align="center" style="height: 100%; width: 100%; font-size: 2.5vw;font-weight: bolder;text-shadow: 2px 2px 7px; border-radius: 5%;"><?php echo $vendeur['nom']; ?></div>
      </div></a>
      <div style="width: 100%; font-size: 1.5vw;margin:auto 0px;<?php
                       if (isMobile()) {
                   ?>
                 font-size: 2.8vw;
                 <?php
                      }
                    ?>">
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> Numero de telephone: <?php echo $vendeur['numero']; ?></div>
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> adresse mail: <?php echo $vendeur['email']; ?></div>
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> site Web: <?php echo $vendeur['site_web']; ?></div>
      </div>
      </div>

     <?php } ?> 
   <div style="justify-content: center;">   
      <div class="main"> 
      <div class="image">
         <img  width="100%" src="img/product_pics/<?php echo($produit['id']); ?>.jpg">
      </div>
      <div class="detail">
          <div class="nom"><?php echo($produit['nom']); ?></div>

          <div class="prix">
             <div><?php echo($produit['prix']); ?> FCFA </div>
             <div style="text-align: right;margin-left: auto; font-size: 1.5vw; font-weight: lighter;font-style: italic;<?php if (isMobile()) {
     ?>
   
     font-size: calc(10px + 2.5vw);
     padding:0.2vw;
   <?php
        }
      ?>"><?php echo($produit['nombre_de_vente']); ?> Vendus</div>
          </div>

           <div class="note">
            <?php 
           if ($produit['nombre_de_vote'] != 0 ) {           
            ?>
            
             <div style="width: 50%; border-radius: 0.5vw; background-color: white; padding: 0.2vw; margin-right: 0.4vw;"><div style="width: <?php  echo round($produit['note']/ $produit['nombre_de_vote'])*10; ?>%; height: 80%; border-radius: 0.5vw; background-color: <?php 
                if ( ($produit['note']/ $produit['nombre_de_vote']) >= 7) {
                  echo "blue";
                }else if (($produit['note']/ $produit['nombre_de_vote']) <= 3) {
                   echo "red";
                }else{
                    echo "orange";
                }
              ?>; padding: 0.2vw"></div></div>
             <?php  echo " ".round($produit['note']/ $produit['nombre_de_vote'])."/10";  ?>
          <div style="text-align: right;margin-left: auto; font-size: 1.5vw;font-weight: lighter;font-style: italic; <?php
         if (isMobile()) {
     ?>
   
     font-size: calc(10px + 2.5vw);
     padding:0.2vw;
   <?php
        }
      ?>"><?php echo($produit['nombre_de_vote']); ?> Votes</div>
            <?php
           }else{
            echo "Le produit n'a pas encore été noté";
           } ?> 
         </div> 
         <form method="post" action="produit.php?id=<?php echo($_GET['id'])?>">
               <?php
                      $count2 = 0; 
                      $count3 = 1;   
                  while ($count2 < $max_number_variante) { 
                       $corresponding_variante = [];   
                       foreach ($variante as $key ) {
                                if ($key['id_variante'] == $count2) {
                                  array_push($corresponding_variante, $key);
                                }
                              }
                            
                  if (count($corresponding_variante) != 0) {
                    ?>
                    <div  class="variante">
                        <span class="title"><?php echo $corresponding_variante[0]['nom_variante']; ?></span>
                  <div style="display: flex;flex-wrap: wrap;margin-top: 2vh;">
                        <?php
                           foreach ($corresponding_variante as $key ) {
                        ?>
                        <div style="margin: 1vw 2vw 1vw 1vw;  <?php
                                                                   if (isMobile()) {
                                                               ?>
                                                             margin: 2vw 2vw 4vw 1vw;
                                                             <?php
                                                                  }
                                                                ?>"><label for="sousvariant<?php  echo $count3; ?>" class="sous_variante">
                          
                            <input type="radio" name="<?php  echo $key['id_variante']; ?>" id="sousvariant<?php  echo $count3; ?>" value="<?php  echo $key['id_sous_variante']; ?>">
                            <?php  echo $key['nom_sous_variante']; ?>
                          </label>
                        </div> 
                   
                        <?php
                             $count3++; } 
                           ?>
                 </div>
                 </div>
                <?php 
                  }
                $count2++;
              } 
              ?>
               <center><div style="display: flex; flex-wrap: wrap;"><input type="submit" name="enregistrer" class="enregistrer" value="Enregistrer"><input type="submit" name="acheter" class="acheter" value="Acheter"><input type="submit" name="panier" class="acheter" value="Ajouter au Panier"><input type="submit" name="rpanier" class="acheter" style="background-color: rgba(250,20,20,0.8);" value="Retirer du Panier"></div></center>
             </form>  
      </div>
      
    </div>


    <aside class="business">
       <div style="<?php
                       if (!isMobile()) {
                   ?>
                 width: 95%;margin: 5% auto 3% auto; height: 40%;
                 <?php
                      }else{
                    ?>
                 width: 180vw;margin: 5% auto 3% auto; height: 35vh;
                    <?php
                       }
                    ?>">
          <span class="title" style="<?php
                       if (isMobile()) {
                   ?>
                 font-size: 3.5vw;
                 <?php
                      }
                    ?>">Autres produits de cette boutique</span>
          <div style="display: flex;flex-wrap: wrap;justify-content: center; width: 100%;margin-top: 10%;height:85%; margin: 5% auto auto auto;">
             <?php 
             $count = 0;
                   while ($count < $req_autre_produit->rowCount()) {

                    $autre_produit = $req_autre_produit->fetch(); 
                     
                      if ( !is_null($autre_produit) ) {
                        ?>
                    <a href="produit.php?id=<?php echo $autre_produit['id']; ?>" style="background-image: url('img/product_pics/<?php echo $autre_produit['id']; ?>.jpg'); background-size: cover;width: 28%;height: 47%; margin: auto;border-radius: 5%; box-shadow: 5px 5px 7px;"> <div>
                       <span><?php echo $autre_produit['nom']; ?></span>
                     </div></a>
                        <?php
                      }
                     $count++;
                   }
             ?>
             <a href="business.php?id=<?php echo $vendeur['id'].'&page=1'; ?>" style="background-color: white; background-size: cover;width: 28%;height: 47%; margin: auto;border-radius: 5%; box-shadow: 5px 5px 7px;"> <div>
                       <span>Tout les produits de cette boutique</span>
                     </div></a>
             
          </div>
      </div>
   <?php if(!isMobile()){ ?>
      <a href="business.php?id=<?php echo $vendeur['id'].'&page=1'; ?>" style="width: 100%;"><div class="profil" style="margin: 1% auto 3% auto;"><div align="center" style="height: 100%; width: 100%; font-size: 2.5vw;font-weight: bolder;text-shadow: 2px 2px 7px; border-radius: 5%;"><?php echo $vendeur['nom']; ?></div>
      </div></a>
      <div style="width: 100%; font-size: 1.5vw;<?php
                       if (isMobile()) {
                   ?>
                 font-size: 2.2vw;
                 <?php
                      }
                    ?>">
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> Numero de telephone: <?php echo $vendeur['numero']; ?></div>
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> adresse mail: <?php echo $vendeur['email']; ?></div>
         <div style="padding: 2%; background-color: rgba(10,10,180,0.3); margin: 1%; border-radius: 1vw;"> site Web: <?php echo $vendeur['site_web']; ?></div>
      </div>
     <?php } ?> 


    </aside>

    <section class="similar_products">
         <span class="title" style="<?php
                       if (isMobile()) {
                   ?>
                 font-size: 3.5vw;
                 <?php
                      }
                    ?>">produits similaire</span>
         <div class="s_similar_products">
        <?php 
           foreach ($produit_similaire as $key) {
        ?>
             <div class="similar_product" style="background-image: url('img/business_profil_pics/<?php echo($key['id']); ?>.jpg'); "><?php echo $key['nom']; ?></div>
        <?php
           }
         ?>
         </div>
    </section>
</div>
<?php include('footer.php'); ?>
</body>
</html>
