<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');


if (isset($_SESSION['id']) )
{
  
    $requser = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
    $requser->execute (array($_SESSION['id']));
    $userinfo= $requser ->fetch();



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
  
  <div class ="upload"> 
  
 
  <input type="file" name="newphoto" /><span>Ajoutez une photo</span></div>

 <div class="uploadalbum">

 <input type="file" /><span>Créez votre album</span></div>




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
      <p>Voici les photos partagées par vos amis !</p>
    </div>
  
 <div class="Gallery">



        <div  class="photostyle">
          <a href="images/imgUser/1.jpg"  data-lightbox="Vacation"data-title= "Moi à la Montagne"> 
         <img src="images/imgUser/1.jpg" width="400px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> Skieurdu77 </p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />Moi à la Montagne</p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
           </p>


      </div>
 <hr>

      
        <div  class="photostyle">
          <a href="images/imgUser/2.jpg" data-lightbox="Vacation"data-title= "Photo2" > 
          <img src="images/imgUser/2.jpg" width="400px" class="img-thumbnail" /></a>
     <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> Thierrylepecheur </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />A la mer avec Jacky</p> 
          <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
           </p>


      </div>

 <hr>
        <div  class="photostyle">
          <a href="images/imgUser/3.jpg" data-lightbox="Vacation"data-title= "Photo3" > 
          <img src="images/imgUser/3.jpg" width="400px" class="img-thumbnail" /></a>
            <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> Kekedu56 </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="20px" class="user" />Sur les plages avec des espagnoles</p>  </p>
          <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 


      </div>
    
 <hr>
 
        <div  class="photostyle">
          <a href="images/imgUser/4.jpg" data-title= "Photo4" data-lightbox="Vacation"> 
          <img src="images/imgUser/4.jpg" width="400px" class="img-thumbnail" /></a>
          <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> TatiMichelle </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />A la plage avec mami</p>
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
            </p>


            </div>

 <hr>
      
        <div  class="photostyle">
          <a href="images/imgUser/5.jpg" data-title= "Photo5" data-lightbox="Vacation"> 
          <img src="images/imgUser/5.jpg" width="400px" class="img-thumbnail" /></a>
          <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> Jordanleboss </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />Concert avec les gars surs</p>
          <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
            </p>
      </div>
 <hr>

        <div  class="photostyle">
          <a href="images/imgUser/6.jpg" data-title= "Photo6" data-lightbox="Vacation"> 
          <img src="images/imgUser/6.jpg" width="400px" class="img-thumbnail" /></a>
          <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> PSGpourlavie </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />Paris dans le coeur</p>
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
            </p>
      </div>


      </div>

      </div>


    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>
  </body>
   <script src="js/lightbox-plus-jquery.min.js"></script>
</html>

<?php
}
else header("Location: connexion.php");
?>