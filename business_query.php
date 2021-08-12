<?php 

      $req_vendeur = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE id=?");
      $req_vendeur->execute(array($getid));
      $vendeur = $req_vendeur->fetch();
      $req_produit = $bdd->prepare("SELECT * FROM produits WHERE id_vendeur=?");
      $req_produit->execute(array($getid));
      $produits = [];
      $num_produit = $req_produit->rowCount();
      $count0 = 0;
      while ($count0 < $num_produit) {
      	array_push($produits, $req_produit->fetch());
      	$count0++;
      }

 ?>