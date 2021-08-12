<?php

$search_term = $_GET['search'];

$req_number_surCategories = $bdd->prepare("SELECT * FROM `sur_categories`");
$req_number_surCategories->execute();
$max_number_surCategories = $req_number_surCategories->rowCount();  

$req_number_Categories = $bdd->prepare("SELECT * FROM `categories`");
$req_number_Categories->execute();
$max_number_Categories = $req_number_Categories->rowCount(); 

 $req_number_sousCategories = $bdd->prepare("SELECT * FROM `sous_categories`");
$req_number_sousCategories->execute();
$max_number_sousCategories = $req_number_sousCategories->rowCount(); 

$search_result_produits = _search_from_produits($bdd,$search_term);
$search_result_categories = _search_from_Categories($bdd,$search_term);


function _search_from_produits($bdd,$search_term){

	$count=1;
	$result_products = [0];

	$query = "SELECT * FROM `produits` WHERE `nom` LIKE '%".$search_term."%'";
	$req_search_produit = $bdd->prepare($query);
	$req_search_produit->execute();
	$number_of_results=$req_search_produit->rowCount();	
    while ( $count <= $number_of_results){
        array_push($result_products, $req_search_produit->fetch());
        $count++;
    }

    $m_query = "SELECT * FROM `produits` WHERE `metaphones` LIKE '%".metaphone($search_term)."%'";
	$req_search_m_produit = $bdd->prepare($m_query);
	$req_search_m_produit->execute();
	$number_of_results +=$req_search_m_produit->rowCount();
    while ( $count <= $number_of_results) {
        $m_product = $req_search_m_produit->fetch();
       
        $exist=0;
        $count2=1;
         while ( $count2 < $count) {
              if (isset($result_products[$count2]) AND $result_products[$count2]['id'] == $m_product['id']) {
              $exist = 1;              
              }
              $count2++;
         }
        if ($exist == 0) {
        	array_push($result_products, $m_product);
               
        }
        $count++;
    }

  return $result_products;

}

function _search_from_Categories($bdd,$search_term){
// -----------------------------------------------------GET sous categories ------------------------------------------//
  $count=0;
  $result_Sous_Categories = [];

  $query = "SELECT * FROM `sous_categories` WHERE `nom` LIKE '%".$search_term."%'";
  $req_search_Sous_Categories = $bdd->prepare($query);
  $req_search_Sous_Categories->execute();
  $number_of_results=$req_search_Sous_Categories->rowCount(); 
    while ( $count < $number_of_results){
        array_push($result_Sous_Categories, $req_search_Sous_Categories->fetch());
        $count++;
    }

    $m_query = "SELECT * FROM `sous_categories` WHERE `metaphones` LIKE '%".metaphone($search_term)."%'";
  $req_search_m_produit = $bdd->prepare($m_query);
  $req_search_m_produit->execute();
  $number_of_results +=$req_search_m_produit->rowCount();
    while ( $count < $number_of_results) {
        $m_product = $req_search_m_produit->fetch();
       
        $exist=0;
        $count2=0;
         while ( $count2 < $count-1) {
              if (isset($result_Sous_Categories[$count2]) AND $result_Sous_Categories[$count2]['id'] == $m_product['id']) {
              $exist = 1;              
              }
              $count2++;
         }
        if ($exist == 0) {
          array_push($result_Sous_Categories, $m_product);
               
        }
        $count++;
    }
// -----------------------------------------------------GET Categories ------------------------------------------//

  $result_Categories = [];
foreach ($result_Sous_Categories as $key) {
  $query = "SELECT * FROM `categories` WHERE `id` = '".$key['id_category']."'";
  $req_search_categories = $bdd->prepare($query);
  $req_search_categories->execute();
  $temp_search_categories = $req_search_categories->fetch();

  array_push($result_Categories, array('id' => $temp_search_categories['id'] ,'nom' => $temp_search_categories['nom'] ,'description' => $temp_search_categories['description'],'id_sur_categories' => $temp_search_categories['id_sur_categories'],'sous_categories' => $key ));
    
}
  
// -----------------------------------------------------GET Sur_Categories ------------------------------------------//

  $result_Sur_Categories = [];
foreach ($result_Categories as $key) {
  $query = "SELECT * FROM `sur_categories` WHERE `id` = '".$key['id_sur_categories']."'";
  $req_search_Sur_Categories = $bdd->prepare($query);
  $req_search_Sur_Categories->execute();
  $temp_search_Sur_Categories = $req_search_Sur_Categories->fetch();
  array_push($result_Sur_Categories, array('id' => $temp_search_Sur_Categories['id'] ,'nom' => $temp_search_Sur_Categories['nom'] ,'description' => $temp_search_Sur_Categories['description'],'categories' => $key ) );
    
}
 
  return $result_Sur_Categories;

}
  ?>