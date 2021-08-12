<?php 
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');


 $reqprod = $bdd->prepare("SELECT * FROM `produits` WHERE `id` > ? ORDER BY `qualite` DESC");
               $reqprod->execute(array(0));
                           
               function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }


 ?>

<html lang="fr">
<head>
  <title>GAEC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatibility" content="ie=edge">
    <?php 
        if(!isMobile()){
          include('css/main.php');
      }else{
            include('css/main-mobile.php');
       }?>
    <link rel="stylesheet" href="aos-master02/dist/aos.css" />
	

</head>
<body>
 
   

    <header>
        <nav>
            <div data-aos="fade-right" class="mainTitle">
                <a href="#" >EDEN</a> 
                <!--    <div class="counter"></div>     -->                 
            </div>
             <div class="options" >       
                <?php if(!isset($_SESSION['id'])) {  ?>
                <a href="inscription.php">Enregistrer/Connecter</a>
              <?php }else{ ?>
                <a href="profil.php"><?php echo $_SESSION['nom']; ?>  -</a>
              <span  class="profilpic"> ----</span>
              <?php } ?>
            </div>
           
         </nav> 
         <br>
         <div data-aos="fade" class="input">
             <form class="searchBar" action="search_result.php">
             <input type="text" name="search" placeholder="Que désirez vous?" size="20">
             </form>    
         </div>  
         <div class="categoriesheader">
            
             <a href="produits.php" class="category" data-aos="flip-left"><div align="center" >
                 <h3>ACHETER</h3><br>
                 <img src="img/buy.png" style="width: 75%; ">
                
             </div></a>
             <a href="produits.php" class="category" data-aos="zoom-in"><div align="center">
                 <h3>ENGAGER</h3><br>
                 <img src="img/hire.png" style="width: 80%;">
             </div></a>
             <a href="produits.php" class="category" data-aos="flip-right"><div align="center">
                 <h3>CARTE</h3><br>
                 <img src="img/map.png" style="width: 80%;">
             </div></a>         
        </div>   
    </header>
    

    <!--    .........................     -->  
    <section>
       <div class="products" data-aos="fade">
             <p><center> <h1 ><a href="#">Quelque Produits </a></h1> </center></p>
             <div class="categories">
                 
                 
                  <div class="category1" align="center">
                     
                       <a href="produit.php?id=<?php $produit = $reqprod->fetch(); echo  $produit["id"]; ?>">
                        <div class="category4" align="center" data-aos="fade-right" style="background-image: url('img/product_pics/<?php echo $produit["id"]; ?>.jpg');">
                      <h3><?php echo  $produit['nom'];?> </h3>        
                       </div>
                       </a>


                       <a href="produit.php?id=<?php $produit = $reqprod->fetch(); echo  $produit["id"]; ?>">
                        <div class="category5" align="center" data-aos="fade-down" style="background-image: url('img/product_pics/<?php echo  $produit["id"];?>.jpg');">
                      <h3><?php echo  $produit['nom'];?> </h3>                    
                       </div>
                        </a>

                       <a href="produit.php?id=<?php $produit = $reqprod->fetch(); echo  $produit["id"]; ?>"><div class="category6" align="center" data-aos="flip-up" style="background-image: url('img/product_pics/<?php echo  $produit["id"];?>.jpg');">
                      <h3><?php echo  $produit['nom'];?> </h3>                      
                       </div>
                       </a>

                  </div>
                  <a href="produit.php?id=<?php $produit = $reqprod->fetch(); echo  $produit["id"]; ?>"><div class="category2" align="center" data-aos="zoom-in" style="background-image: url('img/product_pics/<?php echo  $produit["id"];?>.jpg');">
                      <h3><?php echo  $produit['nom'];?> </h3>                      
                  </div>
                  </a>

                  <div class="category3" align="center" data-aos="zoom-out">
                      <h3>Plus de Produits</h3>
                      
                  </div>
                  
             </div>
            
         </div> 
    </section>
         
     <!--    .........................     --> 
     <section>
        <div class="services" data-aos="fade">
              <p><center> <h1 ><a href="#">Quelque Services </a></h1> </center></p>
              <div class="categories">
                  
                   <div class="category1" align="center">
                      
                        <a href="produit.php?id=1"><div class="category4" align="center" data-aos="fade-right">
                       <h3>type1</h3>
                       
                        </div></a>
                        <a href="produit.php?id=1"><div class="category5" align="center" data-aos="flip-down">
                       <h3>type1</h3>
                       
                        </div></a>
                        <a href="produit.php?id=1"><div class="category6" align="center" data-aos="flip-up">
                       <h3>type1</h3>
                       
                        </div>
                   </div></a>
                  <a href="produit.php?id=1" class="category2" data-aos="zoom-in"> <div  align="center" >
                       <h3>boubara  gfd rdtr</h3>
                       
                   </div></a>
                   <a href="produit.php?id=1"  class="category3" data-aos="zoom-out"><div align="center" >
                       <h3>Plus de Services</h3>
                       
                   </div></a>
                   
              </div>
              
        </div>
     </section> 
     <div class="pages">
           <article class="main-page" data-aos="flip-left">
           <p><center> <h1 ><a href="#"> Eden </a></h2> </center></p>
          <div class="default-text">
            <img src="img/eden2.jpg" width="40%">
          <p>
            Eden est un services en ligne de mise à disposition des produits et services au cameroun au grand public.
          </p>
          <p>
            Nous avons pour but de faciliter le quotidien du Camerounais moyen en mettant a ca dispostion de nombreux produits locaux et facilitant leurs obtention en mettant a diposition des outils tels que des services de commande en ligne et de livraison a domicile. 
          </p> 
          <p>
            Eden est une start-up créé par un groupe d'étudiant dynamique qui on pour but de faciliter le quotidien de chaque Camerounais peut importe leur milieu et leur class social.
          </p>
        </div>

        </article>
        <article class="side-page" data-aos="flip-right">
          <div class="default-text">
            <p><a href="#">Inscrivez-vous</a> et devenez un livreur EDEN et gagnez jusqu'à 1000FCFA par lots de livraison et obtenez des supers bonus sur nos prduits</p>
            <p><a href="#">Inscrivez votre lieu de service</a> entant que point de livraison EDEN et gagnez jusqu'à 500FCFA par lots de produit aquis et obtenez des supers bonus sur nos prduits</p>
            <p><a href="">créez votre page business EDEN gratuitement</a>  et vendez vos produits,faites connaitre votre business et obtenez une clientelle venant de tout le Cameroun</p>
          </div>
        </article>
     </div><br>


    <?php
           include("footer.php"); 
    ?>

    <script src="aos-master02/dist/aos.js"></script>
    <script>
      AOS.init({
        easing: 'ease-out',
        duration: '800',
        delay: '250',
      });
    </script>
     <!-- 
     <script>
      setInterval(addItem, 3);   
      var container = document.getElementById('counter');
      var item = document.createElement('div');
      function addItem () {
        
        item.innerHTML = screen.width + 'x' +  screen.height;
        container.appendChild(item);
      }
    </script>
       .........................     -->
    
    <!--    .........................     -->
    

    <!--    .........................     -->
</body>
</html>