<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');
 
 #------------------------------s'inscrire------------------------- 
  if (isset($_POST['inscrirebus'])) {
  	    
         $pseudobus=htmlspecialchars($_POST['pseudobus']);
           $numero= htmlspecialchars($_POST['numero']);
           $mail=htmlspecialchars($_POST['mail']);
           $siteweb=sha1($_POST['siteweb']);
           $description=sha1($_POST['description']);

  	  if (!empty($_POST['pseudobus']) AND !empty($_POST['numero']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']))
  	  {
  	  	  

  	  	   $pseudolength = strlen($pseudobus);
  	  	   if ($pseudolength <= 20) {
  	  	   	   $reqpseudo = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE nom = ?");
  	  	   	   $reqpseudo->execute(array($pseudobus));
  	  	   	   $pseudoexiste = $reqpseudo->rowCount();                 
  	  	   	    if ($pseudoexiste == 0) 
  	  	   	    {  	  	   	        	       
  	  	   	        	   $insertmbr = $bdd->prepare("INSERT INTO membres_vendeurs(nom,id_membre,mail,site_web,description,numero) VALUES(?,?,?,?,?) ");
  	  	   	        	   $insertmbr->execute(array($pseudobus,$_SESSION['id'],$mail,$siteweb,$description,$numero));   
                         $reqbusiness = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE id_membre = ?");
                         $reqbusiness->execute(array($_SESSION['id']));  
                         $_SESSION['id_vendeur'] = $reqbusiness['id'];        
                         header("Location: profil.php?id=".$_SESSION['id']);    	   	        	        	  	   	        	 
  	  	   	    }else{
                   $errormsg = 'Ce nom est déjà utilisé par un autre business, Veillez le changer';
                }
  	  	   }else{
             $errormsg = 'Le nom de votre business ne doit pas dépasser 20 charactère';
           }

  	  }else{
          $errormsg = 'Veillez remplir tout les champs';
  	  }

  }else if (isset($_POST['inscrireliv'])) {
        
         $pseudoliv=htmlspecialchars($_POST['pseudoliv']);
           $numero= htmlspecialchars($_POST['numeroliv']);
           $mail=htmlspecialchars($_POST['mailliv']);
           $description=sha1($_POST['description']);
          
      if (!empty($_POST['pseudoliv']) AND !empty($_POST['numero']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']))
      {
          

           $pseudolength = strlen($pseudoliv);
           if ($pseudolength <= 20) {
               $reqpseudo = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE nom = ?");
               $reqpseudo->execute(array($pseudoliv));
               $pseudoexiste = $reqpseudo->rowCount();                 
                if ($pseudoexiste == 0) 
                {
                    
                                                     
                               $insertmbr = $bdd->prepare("INSERT INTO membres_vendeurs(nom,id_membre,mail,description,numero) VALUES(?,?,?,?,?) ");
                                $insertmbr->execute(array($pseudoliv,$_SESSION['id'],$mail,$description,$numero)); 
                                header("Location: profil.php?id=".$_SESSION['id']);                               
                                           
                }else{
                   $errormsg = 'Ce pseudo est déjà utilisé par un autre livreur, Veillez le changer';
                }
           }else{
             $errormsg = 'Votre pseudo ne doit pas dépasser 20 charactère';
           }

      }else{
          $errormsg = 'Veillez remplir tout les champs';
      }
  }


?>

<html lang="fr">
<head>
     	<title>Inscrivez-vous</title>
     	 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatibility" content="ie=edge">
         <link rel="stylesheet" href="css/createbusiness.php" type="text/css">
         <link rel="stylesheet" href="aos-master02/dist/aos.css" type="text/css">
     </head>
     <body>
      
         <?php
           include("header.php"); 
           ?>

           <div class="categories">
            
            <a href="createbusiness.php?id=<?php if(isset($_SESSION['id'])) echo $_SESSION['id']?>&type=1"><div class="category" align="center" data-aos="flip-left">
                 <h3>BUSINESS</h3>
                 <img src="img/buy.png" width="80%" height="80%">
                
             </div>
           </a> 
           <a href="createbusiness.php?id=<?php if(isset($_SESSION['id'])) echo $_SESSION['id']?>&type=2">
             <div class="category" align="center"  data-aos="zoom-in" >
                 <h3>LIVREUR</h3>
                 <img src="img/hire.png" width="80%" height="80%">
             </div>
            </a>
             <a href="createbusiness.php?id=<?php if(isset($_SESSION['id'])) echo $_SESSION['id']?>&type=3">
             <div class="category" align="center"  data-aos="flip-right" >
                 <h3>POINT DE LIVRAISON</h3>
                 <img src="img/map.png" width="60%" height="60%">
             </div>  
             </a>           
           </div>

           <?php
           if (isset($errormsg)) {
             echo '
                    <center><div class="error">'.$errormsg.'</div></center>
             ';
           }
         ?>

         

          <div class="mainArticleInscription<?php if (isset($_POST['connexion'])) {echo '1';}?>">                      
              <?php
                     if (intval($_GET['type']) == 1) {
              ?>     

                              <div>
                              	<br>
                                  <center><h2>CRÉEZ VOTRE BUSINESS</h2></center>
                                  <br>
                                  <form method="POST" action="" class="form2">
                                       <table align="center">
                                       	<tr>
                                       		<td align="right" width="50%"><label for="pseudo">Nom du business:</label></td><td><input type="text" placeholder="Entrez le nom du business" id="pseudobus" name="pseudobus" value="<?php if (isset($pseudobus)) {echo $pseudobus;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="50%"><label for="numero">Numero de téléphone du business:</label></td><td><input type="number" placeholder="Entrez le numero de telephone" id="numero" name="numero" value="<?php if (isset($numero)) {echo $numero;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="50%"><label for="mail">Adresse mail du business:</label></td><td><input type="email" placeholder="Entrez votre adresse mail" id="mail" name="mail" value="<?php if (isset($mail)) {echo $mail;} ?>"></td>
                                       	</tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="quartier">Quartier :</label></td>
                                          <td style="position: relative;">
                                            <select name="quartier" id="quartier">
                                              <?php $reqquartier = $bdd->prepare("SELECT * FROM sous_localisation ORDER BY nom ASC");
                                                    $reqquartier->execute();  
                                                    while ($quartier = $reqquartier->fetch()) {
                                                       ?>
                                                  <option value="<?php echo($quartier['id']) ?>">
                                                    <?php echo($quartier['nom']) ?>                                                    
                                                  </option>       
                                                       <?php
                                                     } ?>
                                                                                    
                                            </select>
                                          </td>
                                        </tr>
                                       	<tr>
                                       		<td align="right" width="50%"><label for="description">Décrivez votre business (cette description apparaitra sur la page du business):</label></td><td><textarea id="description" name="description" placeholder="Entrez la description de votre business"></textarea></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="50%"><label for="siteweb">Entrez votre siteWeb (facultatif):</label></td><td><input type="text" placeholder="Entrez votre siteWeb" id="siteweb" name="siteweb"></td>
                                       	</tr>
                                       	<tr>
                                       		<td></td><td><input type="submit" name="inscrirebus" value="Je m'inscris"></td>
                                       	</tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }
                     elseif (intval($_GET['type']) == 2) {
              ?>     

                              <div>
                                <br>
                                  <center><h2>DEVENEZ LIVREUR</h2></center>
                                  <br>
                                  <form method="POST" action="" class="form2">
                                       <table align="center">
                                        <tr>
                                          <td align="right" width="50%"><label for="pseudo">Nom du livreur:</label></td><td><input type="text" placeholder="Entrez le nom du livreur" id="pseudoliv" name="pseudoliv" value="<?php if (isset($pseudoliv)) {echo $pseudoliv;} ?>"></td>
                                        </tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="numeroliv">Numero de téléphone du livreur:</label></td><td><input type="number" placeholder="Entrez le numero de telephone" id="numeroliv" name="numeroliv" value="<?php if (isset($numeroliv)) {echo $numeroliv;} ?>"></td>
                                        </tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="mailliv">Adresse mail du livreur:</label></td><td><input type="email" placeholder="Entrez votre adresse mail" id="mailliv" name="mailliv" value="<?php if (isset($mailliv)) {echo $mailliv;} ?>"></td>
                                        </tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="descriptionliv">Décrivez vous pour vos client (cette description apparaitra sur votre page du livreur):</label></td><td><textarea id="descriptionliv" name="descriptionliv" placeholder="Entrez votre description"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td></td><td><input type="submit" name="inscrireliv" value="Je m'inscris"></td>
                                        </tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }else{
                      ?>
                              <div>
                              	<br>
                                  <center><h2>INSCRIVEZ VOUS COMME POINT DE LIVRAISON</h2></center>
                                  <br>
                                  <form method="POST" action="" class="form2">
                                       <table align="center">
                                       	<tr>
                                       		<td align="right"><label for="pseudopl">Nom du Point de Livraison:</label></td><td><input type="text" placeholder="..." id="pseudopl" name="pseudopl" value="<?php if (isset($pseudopl)) {echo $pseudopl;} ?>"></td>
                                       	</tr>
                                       <tr>
                                          <td align="right" width="50%"><label for="numeropl">Numero de téléphone:</label></td><td><input type="number" placeholder="Entrez le numero de telephone" id="numeropl" name="numeropl" value="<?php if (isset($numeropl)) {echo $numeropl;} ?>"></td>
                                        </tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="mailpl">Adresse mail du livreur:</label></td><td><input type="email" placeholder="Entrez votre adresse mail" id="mailpl" name="mailpl" value="<?php if (isset($mailpl)) {echo $mailpl;} ?>"></td>
                                        </tr>
                                        <tr>
                                          <td align="right" width="50%"><label for="descriptionpl">Décrivez vous pour vos client (cette description apparaitra sur votre page du livreur):</label></td><td><textarea id="descriptionpl" name="descriptionpl" placeholder="Entrez votre description"></textarea></td>
                                        </tr>
                                       	<tr>
                                       		<td></td><td><input type="submit" name="inscrirepl" value="Je m'inscris"></td>
                                       	</tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }
              ?>

         </div> 

        
     <?php
               include("script/script.php"); 
     ?> 

      <script src="aos-master02/dist/aos.js"></script>
    <script>
      AOS.init({
        easing: 'ease-out',
        duration: '800',
        delay: '250',
      });
    </script>
     </body>
</html>

