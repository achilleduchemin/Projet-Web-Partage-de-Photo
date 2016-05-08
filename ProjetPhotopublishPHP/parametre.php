<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');

if (isset($_SESSION['id']) )
{
  
    $requser = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
    $requser->execute (array($_SESSION['id']));
    $userinfo= $requser ->fetch();

// Modification username


    if (isset($_POST['user']) AND !empty($_POST['user'] )AND $_POST['user']!= $userinfo['pseudo'] )
    {     $pseudo= htmlspecialchars($_POST['user']);
     $reqpseudo = $bdd -> prepare("SELECT * FROM membre WHERE pseudo = ?");
      $reqpseudo-> execute (array($pseudo));
      $pseudoexist =  $reqpseudo-> rowCount();
    if($pseudoexist ==0)
    {
      $newpseudo = htmlspecialchars($_POST['user']);
      $insertpeudo =$bdd -> prepare("UPDATE membre SET pseudo = ? WHERE id =?");

      $insertpeudo->execute(array($newpseudo, $_SESSION['id']));
    
      
    }
  else $erreurr="Ce pseudo existe déjà.";
  }
//Modification email
   if (isset($_POST['email']) AND !empty($_POST['email'] )AND $_POST['email']!= $userinfo['mail'] )
    {
      $newmail = htmlspecialchars($_POST['email']);
      $insertmail =$bdd -> prepare("UPDATE membre SET mail = ? WHERE id =?");

      $insertmail->execute(array($newmail, $_SESSION['id']));
      
      
    }

//Modification mdp
    if (isset($_POST['motdepasse']) AND !empty($_POST['motdepasse2'] ) )
    {

      $motdepasse= htmlspecialchars($_POST['motdepasse']);
      $motdepasse2= htmlspecialchars($_POST['motdepasse2']);

      if($motdepasse==$motdepasse2)
      {
          $insertmotdepasse =$bdd-> prepare("UPDATE membre SET motdepasse = ? WHERE id =?");
          $insertmotdepasse ->execute(array($motdepasse, $_SESSION['id']));
       
      }
      else $erreurr = "Les deux mots de passe ne correspondent pas.";


    }



?>

<!DOCTYPE html">
<html lang="fr">
  <head>
		<meta charset ="utf-8"/>
        
      <!-- <link href="css/bootstrap.css"rel="stylesheet" >  -->
        <link href="css/lightbox.css"rel="stylesheet" >
        <link rel="stylesheet" href="Style.css" />

    <title>SePhoto - Mes Photos</title>
     

  </head>
  
  <body>
    
    <h1 id="header"><a href="#" title="Sephoto - Accueil"><p>Profil : <?php echo $userinfo['pseudo']; ?></p><span>PhotoPublish</span></a></h1>

    
    <nav>
      <ul id="menu">
        <li><a href="Accueil.php">Accueil</a></li>
        <li><a href="Mes%20Photos.php#">Mes Photos</a></li>
        <li><a href="#">Parametres</a></li>
        
        <li><a href="deconnexion.php#">Deconnexion</a></li>
      </ul>
    </nav>
    <div id="conteneur">  

    <div id="contenupara">




<div class="inscri">
<h1>Edtion du compte<span>Modifiez vos informations</span></h1>
<form method="POST"action="">
    <div class="section"><span>1</span>Pseudo </div>
    <div class="inner-wrap">
        <label>Votre pseudo <input type="text" name="user" value="<?php echo $userinfo['pseudo']; ?>"/></label>
    </div>

    <div class="section"><span>2</span>Email </div>
    <div class="inner-wrap">
        <label>Votre adresse email <input type="email" name="email"  value="<?php echo $userinfo['mail']; ?>"/></label>
    </div>

    <div class="section"><span>3</span>Mot de passe</div>
        <div class="inner-wrap">
        <label>Entrez votre nouveau mot de passe <input type="password" name="motdepasse" value="<?php echo $userinfo['motdepasse']; ?>" />  </label>
        <label>Confirmez votre mot de passe <input type="password" name="motdepasse2"value="<?php echo $userinfo['motdepasse']; ?>" /></label>
    </div>
    <div class="button-section">
     <input type="submit" name="SignUp" value="Enregistrer les modifications" />

    </div>
</form>
<?php
 if(isset($erreurr)) echo '<font color="red">'.$erreurr. "</font>";
?>






      </div>
      </div>

 



    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>

  <script src="js/lightbox-plus-jquery.min.js"></script>



  </body>
</html>

<?php
}
else header("Location: connexion.php");
?>