<?php

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');




    $requser = $bdd ->prepare('SELECT * FROM membre ');
    $requser->execute (array());
    $countall =  $requser-> rowCount();
    






if(isset($_POST['SignUp']) )
{          
          $pseudo= htmlspecialchars($_POST['user2']);
        
          $mail= htmlspecialchars($_POST['email2']);
          $motdepasse= htmlspecialchars($_POST['motdepasse2']);
          $motdepasse2= htmlspecialchars($_POST['motdepasse22']);

      if(!empty($_POST['user2']) AND !empty($_POST['email2']) AND !empty($_POST['motdepasse2']) AND !empty($_POST['motdepasse22']))
      {
          $reqpseudo = $bdd -> prepare("SELECT * FROM membre WHERE pseudo = ?");
          $reqpseudo-> execute(array($pseudo));
          $pseudoexist =  $reqpseudo-> rowCount();
    if($pseudoexist ==0)
    {
          if ($motdepasse==$motdepasse2) {
            $insertmembre = $bdd->prepare("INSERT INTO membre(pseudo,mail,motdepasse)VALUES (?,?,?)");

            $insertmembre->execute(array($pseudo,$mail,$motdepasse));
           $enregistrer = "Vous êtes bien enregistré(e), connectez vous !";
          }
          else $erreur ="Les deux mots de passe ne correspondent pas.";


           
      
      }
      else
      {
        $erreur = "Pseudo déjà utilisé !";
      }
    }
      else $erreur ="Veuillez remplir tous les champs";

} 



?>



<!DOCTYPE html">
<html lang="fr">
  <head>
		<meta charset ="utf-8"/>
        <link rel="stylesheet" href="Style.css" />
    <title>SePhoto</title>
     

  </head>
  
  <body>
  	 <script src="java.js"></script>

        <h1 id="header"> <a href="#" title="PhotoPublish - Accueil"><p>Profil : ADMINISTRATEUR</p><span>PhotoPublish</span>
    </a></h1>
 <div id="admin">  
 <img src="images/administrateur.jpg">
 <table>
   <tr>
      <th>id</th>
      <th>Pseudo</th>
      <th>email</th>
       <th>SUPPRESSION</th>
   </tr>

          <?php

         while( $donnees =$requser-> fetch()) {



         	          $buttonsupp = "Supprimer".$donnees['id'];

           if (isset($_POST[ $buttonsupp]))
{
           $deleteuser = $bdd ->prepare('DELETE FROM membre WHERE id=?');
         	 $deleteuser->execute (array($donnees['id']));

         	  $deletephotos = $bdd ->prepare('DELETE FROM photos WHERE iduser=?');
         	 $deletephotos->execute (array($donnees['id']));

}

          	?>
          	   <tr>
      <td><?php echo $donnees['id'];?></td>
      <td><?php echo $donnees['pseudo'];?></td>
      <td><?php echo $donnees['mail'];?></td>
      <td>           
      <form method="POST" action="" >
   

              <input type="submit" name="Supprimer<?php echo $donnees['id'] ;?>" value="Supprimer" />
           </form></td>
   </tr>



			<?php
		}
		?>
</table>


<div class="inscri">
<h1>Ajouter un nouvel utilisateur</h1>
<form method="POST"action="">
    <div class="section"><span>1</span>Pseudo </div>
    <div class="inner-wrap">
        <label>Entrez le pseudo <input type="text" name="user2" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>"/></label>
    </div>

    <div class="section"><span>2</span>Email </div>
    <div class="inner-wrap">
        <label>Entrez l'adresse email <input type="email" name="email2"  value="<?php if(isset($mail)) {echo $mail;} ?>"/></label>
    </div>

    <div class="section"><span>3</span>Mot de passe</div>
        <div class="inner-wrap">
        <label>Entrez le mot de passe <input type="password" name="motdepasse2" /></label>
        <label>Confirmez le mot de passe <input type="password" name="motdepasse22" /></label>
    </div>
    <div class="button-section">
     <input type="submit" name="SignUp" />
   
    </div>
</form>

  <?php
      if(isset($erreur)) echo '<font color="red">'.$erreur. "</font>";
     if(isset($enregistrer)) echo '<font color="blue">'.$enregistrer. "</font>";
    
  ?>


</div>
   





    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>
  </body>
</html>