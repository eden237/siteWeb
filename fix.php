<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');
  
   $reqproducts = $bdd->prepare("SELECT * FROM produits");
   $reqproducts->execute();
   while($product = $reqproducts->fetch()) {
   	$m_product = metaphone($product['nom']).' '.metaphone($product['mots cle']);
     $req_insert_products = $bdd->prepare("UPDATE `produits` SET `metaphones` = ? WHERE `produits`.`id` = ?");
   $req_insert_products->execute(array($m_product,$product['id']));
   }
   
    $req_sous_categories = $bdd->prepare("SELECT * FROM sous_categories");
   $req_sous_categories->execute();
   while($sous_categories = $req_sous_categories->fetch()) {
   	$m_sous_categories = metaphone($sous_categories['nom']).' '.metaphone($sous_categories['mots cle']);
     $req_insert_sous_categories = $bdd->prepare("UPDATE `sous_categories` SET `metaphones` = ? WHERE `sous_categories`.`id` = ?");
   $req_insert_sous_categories->execute(array($m_sous_categories,$sous_categories['id']));
   }
  ?>