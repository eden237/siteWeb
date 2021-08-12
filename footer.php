<?php
 if (isset($_SESSION['id'])) {
                $reqbussiness = $bdd->prepare("SELECT * FROM `membres_vendeurs` WHERE `id` = ?");             
                $reqlivreur = $bdd->prepare("SELECT * FROM `livreurs` WHERE `id` = ?");               
                $reqpdl = $bdd->prepare("SELECT * FROM `point_de_livraison` WHERE `id` = ?");
                $reqbussiness->execute(array($_SESSION['id']));
                $reqlivreur->execute(array($_SESSION['id']));
                $reqpdl->execute(array($_SESSION['id']));
              
                $pdl = $reqpdl->fetch();
               $bus = $reqbussiness->fetch();
               $liv = $reqlivreur->fetch();
                }
                 

?>
<link rel="stylesheet" href="css/footer.php" type="text/css">
     <footer>
       <nav>
                 <div>
                    <center><p>Eden237 @Copyright 2021. All rights reserved</p></center> 
                 </div>
                 <div class="footies">
                        <div class="footeurs">  
                          <div class="titres2" style="width: 90%; height: 2.5vw;"><a href="#">Commentaires</a></div>
                          <div class="titres2" style="width: 90%; height: 2.5vw;"><a href="#">Commentaires</a></div>
                         <div class="titres2" style="width: 90%; height: 2.5vw;"><a href="#">Commentaires</a></div>
                               
                       </div>
                       <?php if(!isMobile()){?>
                       <div class="footeurs">  
                           <center><a href="#" class="titres">Produits & Services</a></center><br>
                       </div>
                     <?php }?>
                       <?php if(!isset($_SESSION['id'])) {                        
                                   
                        ?>
                                <div class="footeurs">  
                                  <center><a href="#" class="titres">À propos</a></center><br>
                                   
                                </div>
                       <?php }else{ ?>
                               <div class="footeurs">  
                                <div style="margin-bottom: 1.8vw;"> <a href="#" class="titres">Vos Business</a></div>
                              
                                 <?php if ( isset($bus) && !is_null($bus)) {?>
                                      <div id="business"> <a href="#" style="color: black;"><?php echo $bus['nom'];?></a> </div>
                                  <?php } if (isset($liv) && !is_null($liv)) {?>       
                                      <div id="business"> <a href="#" style="color: black;"><?php echo $liv['nom'];?></a> </div> 
                                  <?php } if (isset($pdl) && $pdl != null) {?>       
                                      <div id="business"> <a href="#" style="color: black;"><?php echo $pdl['nom'];?></a> </div> 
                                  <?php } ?>                                        
                                
                               </div>
                       <?php } ?>
                      
                 </div>
                       
              </nav>
              <div >
                   
              </div>   
     </footer> 