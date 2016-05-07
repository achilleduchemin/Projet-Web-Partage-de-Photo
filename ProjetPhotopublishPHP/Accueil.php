<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');


if (isset($_SESSION['id']) )
{
  
    $requser = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
    $requser->execute (array($_SESSION['id']));
    $userinfo= $requser ->fetch();

    $reqphotoall = $bdd ->prepare('SELECT * FROM photos WHERE partage ="public"ORDER BY id DESC');
    $reqphotoall->execute ();
    //$photoall= $reqphotoall ->fetch();
     $countall =  $reqphotoall-> rowCount();




?>



<!DOCTYPE html">
<html lang="fr">
  <head>
		<meta charset ="utf-8"/>
        <link href="css/lightbox.css"rel="stylesheet" >
        <link rel="stylesheet" href="Style.css" />

    <title>PhotoPublisher</title>
     

  </head>
  
  <body>
  


    <h1 id="header"> <a href="#" title="PhotoPublish - Accueil"><p>Profil : <?php echo $userinfo['pseudo']; ?></p><span>PhotoPublish</span>
    </a></h1>

    <nav>
      <ul id="menu">
        <li><a href="#">Accueil</a></li>
        <li><a href="Mes Photos.php">Mes Photos</a></li>
        <li><a href="parametre.php#">Parametres</a></li>       
        <li><a href="deconnexion.php#">Deconnexion</a></li>
      </ul>
    </nav>
     <div id="conteneur">  
    </br>
    
    <div id="contenu">
      <h2>Fil d'Actualités</h2>
      <p>Voici les photos partagées par vous et vos amis !</p>
    </div>
  
 <div class="Gallery">

          <?php

          while ($photoall= $reqphotoall ->fetch())
          { 


           $requserphoto = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
           $requserphoto->execute (array($photoall['iduser']));
           $userphoto= $requserphoto ->fetch();

         // if(!empty($photoinfo['iduser']))
          //{
          ?>
  
          <div  class="photostyle">
          <a href="images/User/<?php echo $photoall['name']; ?>"  data-lightbox="Vacation"data-title= "<?php echo $photoall['descri']; ?>"> 
         <img src="images/User/<?php echo $photoall['name']; ?>" width="400px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /><?php echo $userphoto['pseudo']; ?></p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" /><?php echo $photoall['descri']; ?></p> 
          <p id="lieu"><img src="images/lieu.png" width="30px" class="user" /><?php echo $photoall['lieu']; ?></p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" /><?php echo $photoall['date']; ?></p> 
           </p>
      </div>
 <hr>
      <?php
       }
       ?>





      </div>


    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  
  </body>
   <script src="js/lightbox-plus-jquery.min.js"></script>
</html>

<?php
}
else header("Location: connexion.php");
?>