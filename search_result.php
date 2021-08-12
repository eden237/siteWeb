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
  
	<title><?php if (isset($_GET['search'])) {
		echo $_GET['search'];
	} ?></title>
</head>
<body>
     
                	<?php 
                  include('header.php');
                  include 'css/search_result.php';
                  ?>
        <div class="main">
                  <?php                   
                  if (isset($_GET['search'])) {
                    include('search_query.php');
                    $number_of_results_produits = count($search_result_produits)-1;
                  ?>
       <table >
       <tr >      
      <td ><span class="headings">Tu as rechercher "<?php echo $_GET['search'].'" ('.$number_of_results_produits.')'; ?></span></td>
        </tr>


        <tr>                                             
                                            <!--           categories          !-->
      <td valign="center">  
      <div class="product" style="overflow: auto; white-space: nowrap;">
        <span class="headings">Categories(s)</span><br>
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
       <div class="sur_category" style="display: inline-block;">
           <br><span class="headings"><?php echo $corresponding_surCategory[0]['nom'];  ?></span> <br><br>
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
                          <div class="sous_category" >
                           <div class="headings"> <?php echo $corresponding_sousCategory[0]['nom'];  ?></div>
                                 
                       </div>
               <?php
                        }
                      $count3++;
                    }?>   
             </div> 
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
        
         </div>
       </td> 
     </tr>


     <tr>
        <!--           Product          !-->
      <td width="60%" valign="top">
        <div class="product">
        <span class="headings" >Produit(s)</span>
                  <?php
                  $count=1;
                  while ($count <= $number_of_results_produits) {           
                 ?>
      <a href="Produit.php?id=<?php echo($search_result_produits[$count]['id']); ?>"> 
        <div class="choice"> 
             <span class="subchoice">
               <img style="border-radius: 10%;" height="100%" src="img/product_pics/<?php echo($search_result_produits[$count]['id']); ?>.jpg">
             </span>
                
                
                  
             <table width="100%" style="text-align: left; padding: 0.5vw;" >
               <tr>                
                  <td width="30%" ><?php echo $search_result_produits[$count]['prix']." FCFA"; ?></td>
                  <td class="nom"> <b><?php echo $search_result_produits[$count]['nom']; ?></b></td>              
               </tr>
               <tr>
                 <td colspan="2">
                  <div class="note">
                           <?php 
                          if ($search_result_produits[$count]['nombre_de_vote'] != 0 ) {           
                           ?>
                           
                            <div style="width: 99%;height: 1vh; border-radius: 0.5vw; background-color: white; padding: 0.2vw; margin-right: 0.1vw;">
                              <div style="width: <?php  echo round($search_result_produits[$count]['note']/ $search_result_produits[$count]['nombre_de_vote'])*10; ?>%; height: 80%; border-radius: 0.5vw; background-color: <?php 
                               if ( ($search_result_produits[$count]['note']/ $search_result_produits[$count]['nombre_de_vote']) >= 7) {
                                 echo "blue";
                               }else if (($search_result_produits[$count]['note']/ $search_result_produits[$count]['nombre_de_vote']) <= 3) {
                                  echo "red";
                               }else{
                                   echo "orange";
                               }
                             ?>; padding: 0.2vw"></div>
                           </div>
                            <?php  echo " ".round($search_result_produits[$count]['note']/ $search_result_produits[$count]['nombre_de_vote'])."/10";  ?>
                         <span style="text-align: right;margin-left: auto; font-size: 1.5vw;font-weight: lighter;font-style: italic; <?php
                        if (isMobile()) {
                    ?>
                  
                    font-size: calc(10px + 2.5vw);
                    padding:0.2vw;
                  <?php
                       }
                     ?>"> (<?php echo($search_result_produits[$count]['nombre_de_vote']); ?> Votes)</div>
                           <?php
                          }else{
                           echo "Le produit n'a pas encore été noté";
                          } ?> 
                        </span> 
       </td>
               </tr>
             </table>  
        </div>
      </a>      
                 <?php    
                    $count++;   
                      } 
                  ?>
       </div></td>
 
       </tr>
       </table>  
   
                  <?php
                  }else{
                 ?>
      <h1>"No Search Term"</h1><br>
      <p>No term was entered to be search. Please enter a term in the search bar</p>
                  <?php    
                        }
	               ?>
         

</div>

</body>
 
</html>