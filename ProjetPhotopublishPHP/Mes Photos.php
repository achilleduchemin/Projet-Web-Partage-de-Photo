<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');

//$bdd = mysql_connect('localhost', 'root', 'root');
//$db_selected = mysql_select_db('bdd', $bdd);


if (isset($_SESSION['id']) )
{
  
    $requser = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
    $requser->execute (array($_SESSION['id']));
    $userinfo= $requser ->fetch();

    $reqphoto = $bdd ->prepare('SELECT * FROM photos WHERE iduser=?');
    $reqphoto->execute (array($_SESSION['id']));
    $photoinfo= $reqphoto ->fetch();
     $count =  $reqphoto-> rowCount();
    //$count=0;
    //while ($donnees =  $reqphoto ->fetch()) {
    //  $count ++;
   // }
    
   // $rows = $reqphoto->fetchAll();
  //  $count=count($rows);
    echo 'Il y a '.$count.' photos.';



   // $photolignes = mysql_num_rows($reqphoto);
   // $photolignes = $reqphoto -> mysql_numrow
if(isset($_FILES['newphoto']) AND !empty ($_FILES['newphoto']['name']) AND $_POST['GO'])

{
  $taillemax = 3097152;
  $extensionsValides = array('jpg', 'jpeg', 'gif','png');

    if($_FILES['newphoto']['size']<= $taillemax)
    {

      $newphoto=$_FILES['newphoto'];

      $extensionupload= strtolower(substr($newphoto['name'],-3));


       // $extensionupload = strtolower(substr(strrchr($_FILES['newphoto']['name'], '.'), 1));
        if(in_array($extensionupload, $extensionsValides))
        {

         move_uploaded_file($newphoto['tmp_name'],"images/User/".$newphoto['name']); 
        $name = $newphoto['name'];

        $insertphoto = $bdd->prepare("INSERT INTO photos (name, iduser, number) VALUES (?,?,?);");
        $number=$count +1;
           $insertphoto->execute(array($name, $_SESSION['id'],$number));



  /*       $result = mysql_query("INSERT INTO photos (name, iduser)
             VALUES ('$name', '$_SESSION['id']')");
       if($result)
        {
          header('Location: Home.php?id='.$_SESSION['ID']);
          exit;
        }

         $chemin = "images/User/".$_SESSION['pseudo'].".".$extensionupload;

            $resultat = move_uploaded_file($_FILES['newphoto']['tmp_name'], $chemin);
            if($resultat)
            {
            $insertphoto = $bdd->prepare("INSERT INTO `espace_membre`.`photos` (`user`) VALUES (?);");

            $insertphoto->execute(array($_SESSION['pseudo'].".".$extensionupload));*/




           //   $updatephoto = $bdd ->prepare('UPDATE membre SET newphoto = :newphoto WHERE id=:id');
             // $updatephoto -> execute(array( 'newphoto' => $_SESSION['id'].".".$extensionupload, 'id'=> $_SESSION['id']));


              $erreur="Photo ajoutée !";
   
        }
        else $erreur = "Votre image doit être aux formats jpg, jpeg, gif ou png. ";
    }
    else
    {
      $erreur = "Votre image ne doit pas dépasser 3 Mo.";
    }

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
     
<!--[if IE]>
<style type="text/css">
html pre
{
  width: 636px ;
}
</style>
<![endif]-->

  </head>
  
  <body>
   <form method="POST" action="" enctype="multipart/form-data">
  <div class ="upload"> 
  
  <input type="file" name="newphoto"/><span>Selectionner une photo</span>
  </div>

   <div class="uploadalbum">
 <input type="submit" name="GO" /><span>Ajouter</span></div>
 </form> 



    <h1 id="header"><a href="#" title="Sephoto - Accueil"><p>Profil : <?php echo $userinfo['pseudo']; ?></p><span>PhotoPublish</span></a></h1>

    
    <nav>
      <ul id="menu">
        <li><a href="Accueil.php">Accueil</a></li>
        <li><a href="Mes%20Photos.php#">Mes Photos</a></li>
        <li><a href="parametre.php">Parametres</a></li>
        
        <li><a href="deconnexion.php#">Deconnexion</a></li>
      </ul>
    </nav>
    <div id="conteneur">  


    <div id="contenu">


      <h2>Mes Photos</h2>
      
      <p>Voici les photos que vous avez partagé.
 

    </div>

     <?php
 if(isset($erreur)) echo '<font color="red">'.$erreur. "</font>";
?></p>



    <div class="Gallery">

<!-- IMAGE UPLOAD -->
          <?php

          for ($i=$count; $i>0;$i--)
          { 
           $reqphoto = $bdd ->prepare('SELECT * FROM photos WHERE iduser=? AND number =?');
          $reqphoto->execute (array($_SESSION['id'],$i));
           $photoinfo= $reqphoto ->fetch();


         // if(!empty($photoinfo['iduser']))
          //{
          ?>
  
          <div  class="photostyle">
          <a href="images/User/<?php echo $photoinfo['name']; ?>"  data-lightbox="Vacation"data-title= "Photo1"> 
         <img src="images/User/<?php echo $photoinfo['name']; ?>" width="400px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> BOBdu67</p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />Moi à la Montagne !</p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
           </p>
      </div>
 <hr>
      <?php
       }
       ?>

        <div  class="photostyle">
          <a href="images/imgUser/1.jpg"  data-lightbox="Vacation"data-title= "Photo1"> 
         <img src="images/imgUser/1.jpg" width="400px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> BOBdu67</p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />Moi à la Montagne !</p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
           </p>


      </div>


      
        <div  class="photostyle">
          <a href="images/imgUser/2.jpg" data-lightbox="Vacation"data-title= "Photo2" > 
          <img src="images/imgUser/2.jpg" width="400px" class="img-thumbnail" /></a>
     <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> BOBdu67 </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />A la mer avec Jacky</p> 
          <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
           </p>


      </div>

 <hr>
        <div  class="photostyle">
          <a href="images/imgUser/3.jpg" data-lightbox="Vacation"data-title= "Photo3" > 
          <img src="images/imgUser/3.jpg" width="400px" class="img-thumbnail" /></a>
            <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> BOBdu67</p>
          <p id="descri"><img src="images/imgdescri.jpg" width="20px" class="user" />Sur les plages avec des espagnoles</p>  </p>
          <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 


      </div>
    
 <hr>
 
        <div  class="photostyle">
          <a href="images/imgUser/4.jpg" data-title= "Photo4" data-lightbox="Vacation"> 
          <img src="images/imgUser/4.jpg" width="400px" class="img-thumbnail" /></a>
          <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /> BOBdu67 </p>
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" />A la plage avec mami</p>
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" />20/05/2015</p> 
            </p>


            </div>

 


      </div>


      </div>

      <!-- <p id="photos"> <img src="montagne.jpg"><br/>
      Sur le lac gele !</p> -->



    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>

  <script src="js/lightbox-plus-jquery.min.js"></script>
<!--<script scr ="js/bootstrap.js"</script>-->


  </body>
</html>

<?php
}
else header("Location: connexion.php");
?>