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

    $reqphoto = $bdd ->prepare('SELECT * FROM photos WHERE iduser=? ORDER BY id DESC');
    $reqphoto->execute (array($_SESSION['id']));
    //$photoinfo= $reqphoto ->fetch();
     $count =  $reqphoto-> rowCount();
    //$count=0;
    //while ($donnees =  $reqphoto ->fetch()) {
    //  $count ++;
   // }
    
   // $rows = $reqphoto->fetchAll();
  //  $count=count($rows);
    $reqphotoall = $bdd ->prepare('SELECT * FROM photos ');
    $reqphotoall->execute ();
    $photoall= $reqphotoall ->fetch();
     $countall =  $reqphotoall-> rowCount();

if(isset($_FILES['newphoto']) AND !empty ($_FILES['newphoto']['name']) AND $_POST['Ajouter'])

{   

   $titre= htmlspecialchars($_POST['titre']);
        
          $lieu= htmlspecialchars($_POST['lieu']);


  $taillemax = 3097152;
  $extensionsValides = array('jpg', 'jpeg', 'gif','png');

    if($_FILES['newphoto']['size']<= $taillemax)
    {

      $newphoto=$_FILES['newphoto'];

      $extensionupload= strtolower(substr($newphoto['name'],-3));


       // $extensionupload = strtolower(substr(strrchr($_FILES['newphoto']['name'], '.'), 1));
        if(in_array($extensionupload, $extensionsValides))
        {
          if(!empty($_POST['titre']) AND !empty($_POST['lieu']))
          {

         move_uploaded_file($newphoto['tmp_name'],"images/User/".$newphoto['name']); 
        $name = $newphoto['name'];
        $date = date("d-m-Y");
        $heure = date("H:i");
        $heureetdate = "Le $date à $heure";

        $id=$countall+1;


       if(isset( $_POST['public']) )
         {
              
              $partage="public";
              
         }
        if(isset($_POST['private'] ))
         {
             
              $partage="private";
         }



        $insertphoto = $bdd->prepare("INSERT INTO photos (name, iduser, number,descri,lieu,date,id,partage) VALUES (?,?,?,?,?,?,?,?);");
        $number=$count +1;
        $insertphoto->execute(array($name, $_SESSION['id'],$number,$titre,$lieu,$heureetdate,$id,$partage));
  


              $erreur="Photo ajoutée !";
   
        }else $erreur = 'Veuillez remplir tous les champs.';
      }
        else $erreur = "Votre image doit être aux formats jpg, jpeg, gif ou png. ";
    }
    else
    {
      $erreur = "Votre image ne doit pas dépasser 3 Mo.";
    }

}


if (isset($_POST['Modifier']) AND isset($_POST['titreancien']) AND isset($_POST['titrenew']) AND isset($_POST['lieunew']))
{
  $titreancien= htmlspecialchars($_POST['titre']);


   $titrenew= htmlspecialchars($_POST['titrenew']);
  $lieunew= htmlspecialchars($_POST['lieunew']);
      




      $updatetitre =$bdd -> prepare("UPDATE photos SET descri = ? AND lieu =? WHERE descri =?");

      $updatetitre->execute(array( $titrenew, $lieunew, $titreancien
        ));




    
      echo "Modifications Enregistrées.";
    
    

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
<!-- PopUP-->
    <script type="text/javascript">
      <!--
          function toggle_visibility(id) {
             var e = document.getElementById(id);
             if(e.style.display == 'block')
                e.style.display = 'none';
             else
                e.style.display = 'block';
          }
      //-->
    </script>





  </head>
  
  <body>


<!--   <form method="POST" action="" enctype="multipart/form-data">
  <div class ="upload"> 
  
  <input type="file" name="newphoto"/><span>Selectionner une photo</span>
  </div>-->


 


   <div class="uploadalbum">


<a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">Ajouter une photo</a> 

 </div>

   <div class="uploadalbum2">


<a href="javascript:void(0)" onclick="toggle_visibility('popupBoxTwoPosition');">Modifier une photo</a> 

 </div>


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
      
      <p>Voici les photos que vous avez partagées.
    
      <br>
  

     <?php 
      echo 'Vous avez '.$count.' photos.';
 if(isset($erreur)) echo '<font color="red">'.$erreur. "</font>";
?></p>
  </div>


    <div class="Gallery">

<!-- IMAGE UPLOAD -->
          <?php

          while ($photoinfo= $reqphoto ->fetch())
          { 


          $buttonsupp = "Supprimer".$photoinfo['id'];

           if (isset($_POST[ $buttonsupp]))
{
           $deletephoto = $bdd ->prepare('DELETE FROM photos WHERE id=?');
          $deletephoto->execute (array($photoinfo['id']));

          //$count--;

          for($j=$countall;$j>0;$j--)
          {
           $reqphotoall = $bdd ->prepare('SELECT * FROM photos WHERE id =?');
          $reqphotoall->execute (array($j));
           $photoinfoall= $reqphoto ->fetch();

           if($photoinfoall['id']>$photoinfo['id'])
           {
            $idmoinsun = $photoinfoall['id']-1;

            $updatenumb =$bdd -> prepare('UPDATE photos SET id = ? WHERE id =?');

            $updatenumb->execute(array( $idmoinsun, $photoinfoall['id']));


           }}



          for($j=$count;$j>0;$j--)
          {
           $reqphotoall = $bdd ->prepare('SELECT * FROM photos WHERE iduser =? AND number=?');
          $reqphotoall->execute (array($userinfo['id'],$j));
           $photoinfoall= $reqphoto ->fetch();

           if($photoinfoall['number']>$photoinfo['number'])
           {
            $idmoinsun = $photoinfoall['number']-1;

            $updatenumb =$bdd -> prepare('UPDATE photos SET number = ? WHERE number =?');

            $updatenumb->execute(array( $idmoinsun, $photoinfoall['number']));


           }



          }
          

}
         // if(!empty($photoinfo['iduser']))
          //{
          ?>
  
          <div  class="photostyle">
          <a href="images/User/<?php echo $photoinfo['name']; ?>"  data-lightbox="Vacation"data-title= "<?php echo $photoinfo['descri']; ?>"> 
         <img src="images/User/<?php echo $photoinfo['name']; ?>" width="400px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /><?php echo $userinfo['pseudo']; ?></p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" /><?php echo $photoinfo['descri']; ?></p> 
          <p id="lieu"><img src="images/lieu.png" width="30px" class="user" /><?php echo $photoinfo['lieu']; ?></p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" /><?php echo $photoinfo['date']; ?></p> 
           </p>
           <p id="partage">
           <?php
           if($photoinfo['partage']=="public") 
            {
           ?>
         <img src="images/public.png" width="50px" class="user" />
          <?php
            }
            else{
          ?>
           <img src="images/private.png" width="50px" class="user" />
           <?php
         }
           ?>
          </p>

          <p id="modif"><a href="javascript:void(0)" onclick="toggle_visibility('popupBoxTwoPosition');"><img src="images/modif.png" width="40px" class="user" /></p> </a>
           </p>
</div>
           <form method="POST" action="" >
   

              <input type="submit" name="Supprimer<?php echo $photoinfo['id'];?>" value="Supprimer" />
           </form>
      
 <hr>
      <?php
       }
       ?>



 


      </div>

      <!-- <p id="photos"> <img src="montagne.jpg"><br/>
      Sur le lac gele !</p> -->



    <p id="footer">Projet Web - Site de Partage de Photos 2016 </p>
  </div>

  <script src="js/lightbox-plus-jquery.min.js"></script>
<!--<script scr ="js/bootstrap.js"</script>-->


    <div id="popupBoxOnePosition">
      <div class="popupBoxWrapper">
        <div class="popupBoxContent">


     



          <div class="ajoutphoto">
          <form method="POST" action="" enctype="multipart/form-data">
<h1>Ajouter une photo <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');"> 
          <img src="images/fermer.png" width="20px" class="img-thumbnail" /></a></h1>
 
    <div class="section"><span>1</span>Choisissez l'image </div>
    <div class="inner-wrap">

   

       <div class ="upload"> 
  
  <input type="file" name="newphoto"/><span>Selectionner une photo</span>
  </div>
    </div>


 
        <div class="section"><span>2</span>Titre</div>
        <div class="inner-wrap">
        <label>Donnez un titre à votre photo <input type="text" name="titre" /></label>
    </div>
       <div class="section"><span>3</span>Lieu</div>
        <div class="inner-wrap">
        <label>Ou avez-vous pris cette photo ?<input type="text" name="lieu" /></label>
    </div>
            <input type="checkbox" name="private" >Photo Privée<input type="checkbox" name="public" >Photo Public
            <br>
          <input type="submit" name="Ajouter" value="Ajouter" />
          
          </div>
        </div>
      </div>
    </div>
</form>


<!-- Modif -->




    <div id="popupBoxTwoPosition">
      <div class="popupBoxWrapper">
        <div class="popupBoxContent">


          <div class="ajoutphoto">
          <form method="POST" action="" >
<h1>Modifications <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxTwoPosition');"> 
          <img src="images/fermer.png" width="20px" class="img-thumbnail" /></a></h1>
 



 
        <div class="section"><span>1</span>Nom</div>
        <div class="inner-wrap">
        <label>Entrez le nom de la photo à modifier <input type="text" name="titre" /></label>
    </div>
       <div class="section"><span>2</span>Entrez les nouvelles informations</div>
        <div class="inner-wrap">
        <label>Modifier le nom<input type="text" name="titrenew" /></label>
    </div>
        <div class="inner-wrap">
        <label>Modifier le lieu<input type="text" name="lieunew" /></label>
    </div>

          <input type="submit" name="Modifier" value="Modifier" />
          
          </div>
        </div>
      </div>
    </div>



</form>



  </body>
</html>

<?php
}
else header("Location: connexion.php");
?>