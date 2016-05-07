<!-- BASE de données connexion -->

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');

/* INSCRIPTION */
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
/* CONNEXION */

if(isset($_POST['Connect']))
{
      $userconnect= htmlspecialchars($_POST['user']);
      $motdepasseconnect= htmlspecialchars($_POST['motdepasse']);

      if(!empty($userconnect) AND !empty($motdepasseconnect))
      {         
           if($userconnect=="administrateur" AND $motdepasseconnect=="administrateur")
              {
                  header("Location: administrateur.php");
              }
                else{
          $requser= $bdd-> prepare("SELECT *FROM membre WHERE pseudo= ? AND motdepasse=?");
          $requser ->execute(array($userconnect,$motdepasseconnect));
          $userexist = $requser->rowCount();
          if($userexist ==1)
          {

            
              $userinfo = $requser ->fetch();
              $_SESSION['id']= $userinfo['id'];
               $_SESSION['pseudo']= $userinfo['pseudo'];
                $_SESSION['mail']= $userinfo['mail'];
                header("Location: Accueil.php?id=".$_SESSION['id']);
              }
        
          else $erreurconnect ="Mauvais pseudo ou mauvais mot de passe !";  
        }
      }
      else  $erreurconnect ="Veuillez remplir tous les champs";

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

    <h1 id="header"><a href="#" title="Sephoto - Accueil"><span>PhotoPublish</span></a></h1>

  <div id="conteneur">  
    
    <div id="contenuaccueil">



  
<div class="inscri">
<h1>Se connecter<span>Déjà membre ? Connectez vous</span></h1>
<form method="POST"action="">
    <div class="section"><span>1</span>Pseudo </div>
    <div class="inner-wrap">
        <label>Entrez votre pseudo <input type="text" name="user" value="<?php if(isset($userconnect)) {echo $userconnect;} ?>"/></label>
    </div>
    <div class="section"><span>2</span>Mot de passe</div>
        <div class="inner-wrap">
        <label>Entrez votre mot de passe <input type="password" name="motdepasse" /></label>
    </div>
    <div class="button-section">
     <input type="submit" name="Connect" />
    </div>
</form>
  <?php
      if(isset($erreurconnect)) echo '<font color="red">'.$erreurconnect. "</font>";
    
  ?>
</div>


<div class="inscri">
<h1>S'enregistrer<span>Inscrivez vous sur notre site!</span></h1>
<form method="POST"action="">
    <div class="section"><span>1</span>Pseudo </div>
    <div class="inner-wrap">
        <label>Choisissez votre pseudo <input type="text" name="user2" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>"/></label>
    </div>

    <div class="section"><span>2</span>Email </div>
    <div class="inner-wrap">
        <label>Entrez votre adresse email <input type="email" name="email2"  value="<?php if(isset($mail)) {echo $mail;} ?>"/></label>
    </div>

    <div class="section"><span>3</span>Mot de passe</div>
        <div class="inner-wrap">
        <label>Entrez votre mot de passe <input type="password" name="motdepasse2" /></label>
        <label>Confirmez votre mot de passe <input type="password" name="motdepasse22" /></label>
    </div>
    <div class="button-section">
     <input type="submit" name="SignUp" />
     <span class="privacy-policy">
     <input type="checkbox" name="field7">Vous acceptez les termes et conditions d'utilisations. 
     </span>
    </div>
</form>

  <?php
      if(isset($erreur)) echo '<font color="red">'.$erreur. "</font>";
     if(isset($enregistrer)) echo '<font color="blue">'.$enregistrer. "</font>";
    
  ?>


</div>
    </div>
    
    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>
  </body>
</html>