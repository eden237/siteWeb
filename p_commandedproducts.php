  <br><br> <br><br><center>
    <div class="commands">
              <?php  $number=$reqcommands->rowCount(); ?>
               <h2>En attente de Livraison  (<?php echo $number; ?>)</h2> 
                <div style="width : auto;
                           height : auto;
                           background-color: rgba(255,255,255,0.5);
                           border-radius: 1vw;
                           padding: 0.5vw; ">
                   <?php 
                        
                         if ( $number > 0) { 
                           
                          $count=0;  while ($commands=$reqcommands->fetch() AND $count <  $number_of_displayed_choice) { 
                           $req_produits_command = $bdd->prepare("SELECT * FROM `produits` WHERE `id` = ?"); 
                           $req_produits_command->execute(array($commands["id_produit"]));
                           $produits_command =$req_produits_command->fetch(); 
                   ?>
                     <script type="text/javascript">
                       commandedProductsArray[<?php echo $count; ?>] = <?php echo($produits_command['id']); ?>
                     </script>    
                    <div class="choice"> 
                      <span>
                        <img style="border-radius: 10%;" height="100%" src="img/product_pics/<?php echo($produits_command['id']) ?>.jpg">
                      </span>
                      <span>
                        <?php echo $produits_command['nom']." | ".$produits_command['prix']." FCFA"; ?> 
                      </span>
                      <span style="margin-left: auto;margin-right: 0.5vw">
                        <img height="50%" src="img/uncheked.jpg" style="border-radius: 2px;">
                      </span>
                    </div>

                   <?php $count++; }   if ( $number >  $number_of_displayed_choice) {  ?> 
                      <center>...</center> <br>
                      <center>
                        <button name="showSavedproducts" class="button" style="text-align: center;">Show All</button>
                      </center><br>

                   <?php }}else if ($number < 1) {?> 
                      <div> Tu n'a pas encore enregistrer de produits...</div><br>
                   <?php }?>
                </div>
                  <br><div class="button" style="width: 45%;"> <a href="produits_services.php" >Produits et Services</a></div><br>
            </div>
</center>