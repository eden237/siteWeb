<?php

      $req_produit = $bdd->prepare("SELECT * FROM produits WHERE id=?");
      $req_produit->execute(array(intval($_GET['id'])));
      $produit = $req_produit->fetch();
      $req_vendeur = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE id=?");
      $req_vendeur->execute(array($produit['id_vendeur']));
      $vendeur = $req_vendeur->fetch();
      $req_autre_produit = $bdd->prepare("SELECT * FROM `produits` WHERE `id` != ? AND `id_vendeur` = ? ORDER BY `nombre_de_vente` DESC");
      $req_autre_produit->execute(array($produit['id'], $vendeur['id']));

  $variante = get_variante($bdd);
 
  $req_number_variante = $bdd->prepare("SELECT * FROM `variante`");
  $req_number_variante->execute();
  $max_number_variante = $req_number_variante->rowCount(); 

  $produit_similaire = get_produit_similaire($bdd,$produit);

 function get_variante($bdd){
    
      $req_produit_x_sv = $bdd->prepare("SELECT * FROM `produits-x-sous_variante` WHERE `id_produit` = ?");
      $req_produit_x_sv->execute(array(intval($_GET['id'])));
      $count = 0;
      $num_result = $req_produit_x_sv->rowCount();
      $produit_x_sv = [];
      $sous_variant = [];
      $r_variant = [];
      $variante = [];
     
      while ($count < $num_result) {
       $produit_x_sv[$count] = $req_produit_x_sv->fetch();

       $req_sous_variante = $bdd->prepare("SELECT * FROM sous_variante WHERE id=?");
       $req_sous_variante->execute(array($produit_x_sv[$count]['id_sous_variante']));
       $sous_variant[$count] = $req_sous_variante->fetch();

        $req_variante = $bdd->prepare("SELECT * FROM variante WHERE id=?");
       $req_variante->execute(array($sous_variant[$count]['id_variante']));
       $r_variant[$count] = $req_variante->fetch();
      
       array_push($variante, array('id_variante' => $r_variant[$count]['id'] ,'nom_variante' => $r_variant[$count]['nom'] , 'id_sous_variante' => $sous_variant[$count]['id'] ,'nom_sous_variante' => $sous_variant[$count]['nom'])); 
       $count++;
      }
    return $variante;
 }
 

  function get_produit_similaire($bdd,$produit){
       
        $req_produit_similaire = $bdd->prepare("SELECT * FROM `produits` WHERE `id_sous_category` = ? AND `id` != ?");
      $req_produit_similaire->execute(array($produit['id_sous_category'], $produit['id'])); 
      $count=0;
      $num_result = $req_produit_similaire->rowCount();
      $produit_similaire =[];
       while ($count < $num_result) {
         $produit_similaire[$count] = $req_produit_similaire->fetch();
         $count++;
       }
       return $produit_similaire;
  }
?>