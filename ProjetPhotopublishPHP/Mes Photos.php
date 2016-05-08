<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','');



if (isset($_SESSION['id']) )
{
  
    $requser = $bdd ->prepare('SELECT * FROM membre WHERE id=?');
    $requser->execute (array($_SESSION['id']));
    $userinfo= $requser ->fetch();

    $reqphoto = $bdd ->prepare('SELECT * FROM photos WHERE iduser=? ORDER BY id DESC');
    $reqphoto->execute (array($_SESSION['id']));
    //$photoinfo= $reqphoto ->fetch();
     $count =  $reqphoto-> rowCount();

    $reqphotoall = $bdd ->prepare('SELECT * FROM photos ');
    $reqphotoall->execute ();
    $photoall= $reqphotoall ->fetch();
     $countall =  $reqphotoall-> rowCount();


    $reqalbum = $bdd ->prepare('SELECT * FROM album WHERE iduser=? ORDER BY id DESC');
    $reqalbum->execute (array($_SESSION['id']));
    //$photoinfo= $reqphoto ->fetch();
     $countalbum =  $reqalbum-> rowCount();


    $reqalbumbox = $bdd ->prepare('SELECT * FROM album WHERE iduser=? ORDER BY id DESC');
    $reqalbumbox->execute (array($_SESSION['id']));


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

        if( $_POST['selectalbum']=="Aucun")
        {
            $album="Aucun";
        }else{
            $album = $_POST['selectalbum'];
        }


        $insertphoto = $bdd->prepare("INSERT INTO photos (name, iduser, number,descri,lieu,date,id,partage, nomalbum) VALUES (?,?,?,?,?,?,?,?,?);");
        $number=$count +1;
        $insertphoto->execute(array($name, $_SESSION['id'],$number,$titre,$lieu,$heureetdate,$id,$partage, $album));
  


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

/*
if (isset($_POST['Modifier']) AND isset($_POST['titreancien']) AND isset($_POST['titrenew']) AND isset($_POST['lieunew']))
{
  $titreancien= htmlspecialchars($_POST['titre']);


   $titrenew= htmlspecialchars($_POST['titrenew']);
  $lieunew= htmlspecialchars($_POST['lieunew']);
      




      $updatetitre =$bdd -> prepare("UPDATE photos SET descri = ? AND lieu =? WHERE descri =?");

      $updatetitre->execute(array( $titrenew, $lieunew, $titreancien
        ));




    
      echo "Modifications Enregistrées.";
    
    

}*/
if (isset($_POST['Creer']) AND isset($_POST['titrealbum']) AND isset($_POST['descrialbum']) )
{


      $namealbum= htmlspecialchars($_POST['titrealbum']);
      $descrialbum= htmlspecialchars($_POST['descrialbum']);
      $insertalbum = $bdd->prepare("INSERT INTO album (name, iduser,descri) VALUES (?,?,?);");
   
      $insertalbum->execute(array($namealbum, $_SESSION['id'], $descrialbum));
      $erreur = "Album Créé !";


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




 


   <div class="uploadalbum">


<a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">Ajouter une photo</a> 

 </div>

   <div class="uploadalbum2">


<a href="javascript:void(0)" onclick="toggle_visibility('popupBoxTwoPosition');">Modifier une photo</a> 

 </div>
  <div class="uploadalbum3">


<a href="javascript:void(0)" onclick="toggle_visibility('popupBoxThreePosition');">Créer un album</a> 

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
     
   

              <input type="submit" name="Info<?php echo $photoinfo['id'];?>" value="Informations" />
           </form>
             <?php
          $buttoninfo = "Info".$photoinfo['id'];

           if (isset($_POST[ $buttoninfo]))
{
            $adresse = "images/User/".$photoinfo['name'];

              $exif = exif_read_data($adresse, 0, true);
        echo "Nom de la photo :<br />\n" .$photoinfo['name'];
        foreach ($exif as $key => $section) {
        foreach ($section as $name => $val) {
         echo "$key.$name: $val<br />\n";
  }
}

}
             ?>
      
 <hr>
      <?php

       }
       ?>


<br><br>
   
    <div id="contenu">
 <div class="Gallery">

      <h2>Mes Albums</h2>
      
      <p>Voici les albums que vous avez partagés.
    
      <br>

  

     <?php 
      echo 'Vous avez '.$countalbum.' albums.';
 if(isset($erreur)) echo '<font color="red">'.$erreur. "</font>";
?></p>
  </div>
 <?php

          while ($album= $reqalbum ->fetch())
          { 
        $reqphotoalbum = $bdd ->prepare('SELECT * FROM photos WHERE nomalbum =? ');
       $reqphotoalbum->execute (array($album['name']));
    //$photoall= $reqphotoall ->fetch();
     $countallphotoalbum =  $reqphotoalbum-> rowCount();




            ?>
<table>
   <tr>
      <th>id</th>
      <th>Album</th>
      <th>Description</th>
      <th>Nombre de Photos</th>
   </tr>
   

               <tr>
      <td><?php echo $album['id'];?></td>
      <td><?php echo $album['name'];?></td>
      <td><?php echo $album['descri'];?></td>
      <td><?php echo $countallphotoalbum; ?></td>
      </tr>

</table>
        <?php

        while($photoalbum = $reqphotoalbum-> fetch())
        {




        ?>



          <div  class="photostyle">
          <a href="images/User/<?php echo $photoalbum['name']; ?>"  data-lightbox="Vacation"data-title= "<?php echo $photoalbum['descri']; ?>"> 
         <img src="images/User/<?php echo $photoalbum['name']; ?>" height="200px" /> </a>

          
         <p>
         
         <p id="user"><img src="images/iconuser.png" width="40px" class="user" /><?php echo $userinfo['pseudo']; ?></p>
         
          <p id="descri"><img src="images/imgdescri.jpg" width="30px" class="user" /><?php echo $photoalbum['descri']; ?></p> 
          <p id="lieu"><img src="images/lieu.png" width="30px" class="user" /><?php echo $photoalbum['lieu']; ?></p> 
           <p id="date"><img src="images/iconhorloge.png" width="20px" class="user" /><?php echo $photoalbum['date']; ?></p> 
           </p>
        </div>
 <hr>
 <?php
  }
  ?>


    <?php
  }
  ?>
</div>



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
            <div class="section"><span>4</span>Visibilité de la photo</div>
        <div class="inner-wrap">
        <label> Indiquez si votre photo est public ou privée :</label>
   
            <input type="checkbox" name="private" >Photo Privée<input type="checkbox" name="public" >Photo Public
            <br> 
            <br> 
            </div>

                    <div class="section"><span>5</span>Album</div>

        <div class="inner-wrap">
        <label>Dans quel album mettre cette photo ?</label>
   
            <select name="selectalbum">
             <option value="Aucun"selected>Aucun </option>
                <?php
                while($albuminfo= $reqalbumbox ->fetch())
                {
                  ?>
              <option value="<?php echo$albuminfo['name'] ?>"selected><?php echo$albuminfo['name'] ?> </option>
                  
                  <?php
                  }
              ?> </div>

            </select>
          <input type="submit" name="Ajouter" value="Ajouter" />
          </div>
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


    <div id="popupBoxThreePosition">
      <div class="popupBoxWrapper">
        <div class="popupBoxContent">


          <div class="ajoutphoto">
          <form method="POST" action="" >
        <h1>Création Album <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxThreePosition');"> 
          <img src="images/fermer.png" width="20px" class="img-thumbnail" /></a></h1>
 



 
        <div class="section"><span>1</span>Nom</div>
        <div class="inner-wrap">
        <label>Entrez le nom de l'album <input type="text" name="titrealbum" /></label>
    </div>
       <div class="section"><span>2</span>Donnez une description à votre album</div>
        <div class="inner-wrap">
       <input type="text" name="descrialbum" />
    </div>
   

          <input type="submit" name="Creer" value="Créer" />
          
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