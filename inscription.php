<?php
session_start();
$bdd = new PDO('mysql:host=db5002799380.hosting-data.io;dbname=dbs2236295','dbu1053082','iamanedenadmin');
  function isMobile() {
                     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
               }
 #------------------------------s'inscrire------------------------- 
  if (isset($_POST['inscrire'])) {
  	    
         $pseudo=htmlspecialchars($_POST['pseudo']);
           $date= htmlspecialchars($_POST['date']);
           $mail=htmlspecialchars($_POST['mail']);
           $mail2=htmlspecialchars($_POST['mail2']);
           $mdp=sha1($_POST['mdp']);
           $mdp2=sha1($_POST['mdp2']);

  	  if (!empty($_POST['pseudo']) AND !empty($_POST['date']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
  	  {
  	  	  

  	  	   $pseudolength = strlen($pseudo);
  	  	   if ($pseudolength <= 20) {
  	  	   	   $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE nom = ?");
  	  	   	   $reqpseudo->execute(array($pseudo));
  	  	   	   $pseudoexiste = $reqpseudo->rowCount();                 
  	  	   	    if ($pseudoexiste == 0) 
  	  	   	    {
  	  	   	        if ($mail == $mail2) 
  	  	   	        {
  	  	   	        	   $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
  	  	   	        	   $reqmail->execute(array($mail));
  	  	   	        	   $mailexiste = $reqmail->rowCount();
  	  	   	        	   if ($mailexiste == 0) 
  	  	   	        	   {
  	  	   	        	       if ($mdp == $mdp2)
  	  	   	        	        {
  	  	   	        	        	$insertmbr = $bdd->prepare("INSERT INTO membres(nom,mail,password,date) VALUES(?,?,?,?) ");
  	  	   	        	        	$insertmbr->execute(array($pseudo,$mail,$mdp,$date));
                                $requser = $bdd->prepare("SELECT * FROM membres WHERE nom=? AND password=?");
                                $requser->execute(array($pseudo,$mdp));
                                $userinfo = $requser->fetch();
                                $_SESSION['id'] =$userinfo['id']; 
                                $_SESSION['nom'] =$userinfo['nom']; 
                                  $_SESSION['mail'] =$userinfo['mail'];  
                                header("Location: profil.php?id=".$_SESSION['id']);    

  	  	   	        	        }else{
                                     $errormsg = 'les mot de passes ne correspondent pas, veillez entrer le même';
  	  	   	        	        }
  	  	   	        	   }else{
                          $errormsg = 'Ce mail est deja associé à un compte veillez vous <bold>Connecter</bold>';
                         }
  	  	   	        	   
  	  	   	        }else{
                         $errormsg = 'les mails sont different!, veillez entrer le même';
  	  	   	        }
  	  	   	    }else{
                   $errormsg = 'Ce pseudo est déjà utilisé par un autre utilisateur, Veillez le changer';
                }
  	  	   }else{
             $errormsg = 'Votre pseudo ne doit pas dépasser 20 charactère';
           }

  	  }else{
          $errormsg = 'Veillez remplir tout les champs';
  	  }
  }

   if (isset($_POST['connecter'])) {
  	       $pseudocon=htmlspecialchars($_POST['pseudocon']);  

  	  	   $mdpcon=sha1($_POST['mdpcon']);
  	  if (!empty($_POST['pseudocon']) AND !empty($_POST['mdpcon']))
  	  {

  	  	   $requser = $bdd->prepare("SELECT * FROM membres WHERE nom=? AND password=?");
  	  	    $requser->execute(array($pseudocon,$mdpcon));
  	  	    $userexiste = $requser->rowCount();
  	  	    if ($userexiste > 0) 
  	  	    {
  	  	    	echo "oookkkk";
  	  	    	$userinfo = $requser->fetch();
  	  	    	$_SESSION['id'] =$userinfo['id']; 
  	  	    	$_SESSION['nom'] =$userinfo['nom'];  
  	  	    	$_SESSION['mail'] =$userinfo['mail'];  
               $reqbusiness = $bdd->prepare("SELECT * FROM membres_vendeurs WHERE id_membre = ?");
                         $reqbusiness->execute(array($_SESSION['id'])); 
                         $businessExist = $reqbusiness->rowCount();
                         if ($businessExist != 0) {
                             $_SESSION['id_vendeur'] = $reqbusiness['id']; 
                          } 
                        
  	  	    	header("Location: profil.php?id=".$_SESSION['id']); 	  	    
  	  	    }else{
  	  	    	echo $mdpcon;
  	  	    }

  	  }
  	}

?>

<html>
     <head>
     	<title>Inscrivez-vous</title>
     	 <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta http-equiv="X-UA-Compatibility" content="ie=edge">
         <link rel="stylesheet" href="css/inscription.php" type="text/css">
         <link rel="stylesheet" href="aos-master02/dist/aos.css" />
     </head>
     <body>
         <?php
           include("header.php"); 
           if (isset($errormsg)) {
             echo '
                    <center><div class="error">'.$errormsg.'</div></center>
             ';
           }
         ?>
          <div class="mainArticleInscription<?php if (isset($_POST['connexion'])) {echo '1';}?>">
         	<form method="POST" action="" class="form">
         		<input type="submit" name="inscription" value="Inscription" class="<?php if (!isset($_POST['inscription']) AND isset($_POST['connexion'])) {echo 'non';}?>selectedForm" >
         		<input type="submit" name="connexion" value="Connexion" class="<?php if (!isset($_POST['connexion'])) {echo 'non';}?>selectedForm" >
         	</form>                                  
              <?php
                     if (isset($_POST['inscription'])) {
              ?>     

                              <div>
                              	<br>
                                  <center><h2>Inscrivez-vous</h2></center>
                                  <br>
                                  <form method="POST" action="" class="forminscription">
                                       <table align="center">
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="pseudo">Nom d'utilisateur:</label></td><td><input type="text" placeholder="Entrez votre nom" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) {echo $pseudo;} ?>" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="date">Date de naissance:</label></td><td><input type="date" placeholder="Choisisez une date" id="date" name="date" value="<?php if (isset($date)) {echo $date;} ?>" ></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="mail">Adresse mail:</label></td><td><input type="email" placeholder="Entrez votre adresse mail" id="mail" name="mail" value="<?php if (isset($mail)) {echo $mail;} ?>" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="mail2">Confirmation d'Adresse mail:</label></td><td><input type="email" placeholder="Confirmez votre adresse mail" id="mail2" name="mail2" value="<?php if (isset($mail2)) {echo $mail2;} ?>" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="mdp">Mot de passe:</label></td><td><input type="password" placeholder="Entrez votre mot de passe" id="mdp" name="mdp" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="mdp2">Confirmez votre Mot de passe:</label></td><td><input type="password" placeholder="Confirmez votre mot de passe" id="mdp2" name="mdp2" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td class="leftTd"></td><td><input type="submit" name="inscrire" value="Je m'inscris" class="submits"></td>
                                       	</tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }
                     elseif (isset($_POST['connexion'])) {
                     	?>
                              <div>
                              	<br>
                                  <center><h2>Connectez-vous</h2></center>
                                  <br>
                                  <form method="POST" action="" class="formconnexion">
                                       <table align="center">
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="pseudocon">Nom d'utilisateur:</label></td><td><input type="text" placeholder="Entrez votre nom" id="pseudocon" name="pseudocon" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" class="leftTd" width="30%"><label for="mdpcon">Confirmez votre Mot de passe:</label></td><td><input type="password" placeholder="Entrez votre mot de passe" id="mdpcon" name="mdpcon" class="inputs"></td>
                                       	</tr>
                                       	<tr>
                                       		<td class="leftTd"></td><td><input type="submit" name="connecter" value="Me Connecter" class="submits"></td>
                                       	</tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }else{
                      ?>
                              <div>
                              	<br>
                                  <center><h2>Inscrivez-vous</h2></center>
                                  <br>
                                  <form method="POST" action="" class="forminscription">
                                       <table align="center">
                                       	<tr>
                                       		<td align="right" width="30%"><label for="pseudo">Nom d'utilisateur:</label></td><td><input type="text" placeholder="Entrez votre nom" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) {echo $pseudo;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="30%"><label for="date">Date de naissance:</label></td><td><input type="date" placeholder="Choisisez une date" id="date" name="date" value="<?php if (isset($date)) {echo $date;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="30%"><label for="mail">Adresse mail:</label></td><td><input type="email" placeholder="Entrez votre adresse mail" id="mail" name="mail" value="<?php if (isset($mail)) {echo $mail;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="30%"><label for="mail2">Confirmation d'Adresse mail:</label></td><td><input type="email" placeholder="Confirmez votre adresse mail" id="mail2" name="mail2" value="<?php if (isset($mail2)) {echo $mail2;} ?>"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="30%"><label for="mdp">Mot de passe:</label></td><td><input type="password" placeholder="Entrez votre mot de passe" id="mdp" name="mdp"></td>
                                       	</tr>
                                       	<tr>
                                       		<td align="right" width="30%"><label for="mdp2">Confirmez votre Mot de passe:</label></td><td><input type="password" placeholder="Confirmez votre mot de passe" id="mdp2" name="mdp2"></td>
                                       	</tr>
                                       	<tr>
                                       		<td></td><td><input type="submit" name="inscrire" value="Je m'inscris" class="submits"></td>
                                       	</tr>
                                       </table>
                                  </form>
                             </div>
                     	<?php
                     }
              ?>

         </div> <br><br>

          <?php
           include("footer.php"); 
    ?>
        

     </body>
</html>