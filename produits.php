<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');

 function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />


  <?php   
   include('produits_query.php');
   include("css\produit-service.php");
   echo " cat: ".$max_number_Categories;
   ?>


	<title>Nos Produits et Services</title>
</head>
<body>
  
                	
                    
   
<div class="main">
<div style="position: fixed;width: 25%;height: 100%;">
       
    <nav class="list">
      <div class="searches">
           <form class="searchBar" action="search_result.php">
              <input type="text" name="search" placeholder="Que désirez vous?" size="20" class="search">
              <input type="submit" name="submit" placeholder="chercher" class="submit">
           </form>  
       </div>
    <?php
       $count=1;
                  while ($count <= $max_number_surCategories) { 
                       $corresponding_surCategory = [];   
                       foreach ($search_result_categories as $key ) {
                                if ($key['id'] == $count) {
                                  array_push($corresponding_surCategory, $key);
                                }
                              }
                          
    ?>
       <a href="#<?php echo($corresponding_surCategory[0]['id']); ?>"><div class="surCategory"> <?php echo($corresponding_surCategory[0]['nom']); ?> </div></a>
    <?php
       $count++;}
    ?>
      
    </nav>
 
</div>

  <aside class="list2">
    <?php
                  $count=1;
                  while ($count <= $max_number_surCategories) { 
                       $corresponding_surCategory = [];   
                       foreach ($search_result_categories as $key ) {
                                if ($key['id'] == $count) {
                                  array_push($corresponding_surCategory, $key);
                                }
                              }
                             
                  if (count($corresponding_surCategory) != 0) {
                    
                  ?>
       <div class="sur_category">
           <center><span class="headings" id="<?php echo($corresponding_surCategory[0]['id']); ?>"><?php echo $corresponding_surCategory[0]['nom'];  ?></span></center> <br>
                  <?php
                      $count2 = 1;    
                  while ($count2 <= $max_number_Categories) { 
                       $corresponding_Category = [];   
                       foreach ($corresponding_surCategory as $key ) {
                                if ($key['categories']['id'] == $count2) {
                                  array_push($corresponding_Category, $key['categories']);
                                }
                              }
                            
                  if (count($corresponding_Category) != 0) {
                    ?>
             <div class="category">
                  <span class="headings"><?php echo $corresponding_Category[0]['nom'];  ?></span><br>
                   <div class="s-category">
                        <?php
                            $count3 = 1;    
                        while ($count3 <= $max_number_sousCategories) { 
                             $corresponding_sousCategory = [];   
                             foreach ($corresponding_Category as $key ) {
                                      if ($key['sous_categories']['id'] == $count3) {
                                        array_push($corresponding_sousCategory, $key['sous_categories']);
                                      }
                                    }
                                   
                        if (count($corresponding_sousCategory) != 0) {
                           ?>
                      <center> <div class="sous_category" >
                           <div class="sc-headings"> <?php echo $corresponding_sousCategory[0]['nom'];  ?></div>
                                 
                       </div> </center>
               <?php
                        }
                      $count3++;
                    }?>   
             </div> </div>
               <?php
                  }
                $count2++;
              }?>   
       </div>  
                 <?php  
                 }  
                    $count++;   
                      } 
                  ?>
  </aside>
</div>
</body>
 
</html>