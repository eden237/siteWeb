<?php include('css/saved_product_navbar.php');  ?>
<div style="display: flex; margin-left: 2px;" class="saved_product_bar">
    <div style="height: 8vh; width: 6%; display: inline-block;border-radius:5px;margin-top: 1vh;background-color: white;box-shadow: 5px 5px 7px black;
    <?php
         if (isMobile()) {
     ?>
   width: 18%;
   <?php
        }
      ?>"><div style="width: 100%; height: 100%;background-image: url('img/buy.jpg');background-size: contain;background-position: center;background-repeat: no-repeat;"></div></div>
   <div class="saved_product_scroll">
    
     <?php
         if (isset($_SESSION['vendeur'])) {
          $cook = $_SESSION['vendeur'];
          foreach ($cook as $key => $value) {
            ?>
            <div style="width: 30%;height: 90%; padding-top: 1%; display: inline-block;background-color: rgba(20,20,255,0.4);margin: 4px;border-radius:10px; <?php
                     if (isMobile()) {
                 ?>
               width: 65%;
               padding-top: 0.5%;
               margin-top: 1px;
               <?php
                    }
                  ?>">
            
             <span class="title" style="margin-bottom: 1vh;font-size: 1.1vw;
                                                                             <?php
                                                                                 if (isMobile()) {
                                                                             ?>
                                                                            font-size: 2.8vw;
                                                                           <?php
                                                                                }
                                                                              ?>"><?php echo $value['nom_vendeur']; ?> (<?php echo $value['prix_totale']; ?>)</span>
             <input type="submit" name="acheter_panier" value="Acheter Panier" style="margin-top: -2vh;" class="acheter_saved" >
                <div class="product_list">
          <?php
             foreach ($value['produits'] as $key) {
            ?>
              <a href="produit.php?id=<?php echo($key['id_produit']); ?>"><div class="saved_product" style="background-image:url('img/product_pics/<?php echo($key['id_produit']); ?>.jpg');">
                <span class="sous_saved_product"><?php echo $key['nom_produit']; ?></span><br><br>
              
                <?php foreach ($key['variante'] as $key2) {
                echo "<span class=\"sous_saved_product\">".$key2['nom_sous_variante']['nom']."</span><br><br>";
              } ?>
                
              
            </div></a>
            <?php   
             }
             ?>
               </div>
            </div>
             <?php
            }
            ?>

           <?php
          }
         ?>
   </div>
   </div>