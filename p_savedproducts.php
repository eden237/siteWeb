 <br><br> <br><br><center><div class="p-Savedproducts" >
              <?php  $number=$reqsaved->rowCount(); ?>
                <h2>En attente d'achat  (<?php echo $number; ?>)</h2>
               <div style="width : auto;
                           height : auto;
                           background-color: rgba(255,255,255,0.5);
                           border-radius: 1vw;
                           padding: 0.5vw; ">
                   <?php 
                        
                         if ( $number > 0) { 
                           
                          $count=0;  while ($saved=$reqsaved->fetch() AND $count <  $number) { 
                           $req_produits_saved = $bdd->prepare("SELECT * FROM `produits` WHERE `id` = ?"); 
                           $req_produits_saved->execute(array($saved["id_produit"]));
                           $produits_saved =$req_produits_saved->fetch(); 
                   ?>
                     <script type="text/javascript">
                       savedProductsArray[<?php echo $count; ?>] = <?php echo($produits_saved['id']); ?>
                     </script>   
                    <div class="choice" id="Savedproducts<?php echo $produits_saved['id']; ?>"> 
                      <span>
                        <img style="border-radius: 10%;" height="100%" src="img/product_pics/<?php echo($produits_saved['id']); ?>.jpg">
                      </span>
                      <span>
                        <?php echo $produits_saved['nom']." | ".$produits_saved['prix']." FCFA"; ?> 
                      </span>
                      
                        <img id="Savedproductsimg" height="50%" src="img/uncheked.jpg" style="border-radius: 2px; position: absolute;left:90%;">
                        <img  id="Savedproductsimg<?php echo $produits_saved['id']; ?>" height="50%" src="img/cheked.jpg" style="border-radius: 2px;z-index: -10;position: absolute;left:90%;">
                      
                    </div>

                   <?php $count++; } }else if ($number < 1) {?> 
                      <div> Tu n'a pas encore enregistrer de produits...</div><br>
                   <?php }?>
                </div>
                  <br><div id="buySaved"></div><div class="button" style="width: 45%;"> <a href="produits_services.php" >Produits et Services</a></div><br>
            </div>
</center>