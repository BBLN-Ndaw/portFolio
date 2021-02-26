<?php
//dans le fichier include.php on a mis l'inclusion du fichier auth.php car cette page (edit_realisation) ne peut être afficher que si on se connecte.
include '../librairie/include.php';
 include '../lesMorceauxDePages/admin_header.php';
?>
<?php
if(isset($_POST['name'])&& isset($_POST['categorie_id']))// ce code s'execute quand on appuie sur enregistrer
{
     // var_dump($_POST); contient ce que l'utilsateur a mis dans le formulare, ce qu'on a envoyé apres avoir appuyer sur enregistrer
     // var_dump($_FILES);//variable du langage qui contient les infos sur les fichiers 
     // checkcsrf();
      $slug=$_POST['slug'];
      if(preg_match('/^[a-z\-0-9]+$/',$slug))//preg_match permet de tester une expression regulier
      {
            $name=$mydb->quote($_POST['name']);//j'enleve les mauvaises caracteres que l'utilsateur à mis dans la zone de text
            $category_id=$mydb->quote($_POST['categorie_id']);
            $slugAvecGuillemet=$mydb->quote($_POST['slug']);
            $description=$mydb->quote($_POST['description']);//quote ça met des guillemets au tour de la vvaraible
            /**
             * mis a jour de d'une realisation qui existe déja  
             * */
           if(isset($_GET['id']))
            {
                  $id=$mydb->quote($_GET['id']);
                  $name=$mydb->quote($_POST['name']);
                  $category_id=$mydb->quote($_POST['categorie_id']);
                  $slugAvecGuillemet=$mydb->quote($_POST['slug']);
                  $description=$mydb->quote($_POST['description']);

                  $requete=$mydb->query("UPDATE realisations SET name=$name, slog=$slugAvecGuillemet, 
                  contenue=$description,categorie_id=$category_id WHERE id=$id");
            }
            else{
                   /**
                    * enregistrement d'une réalisation dans la base de donnée
                    */
                  $requete=$mydb->query("INSERT INTO realisations SET name=$name, slog=$slugAvecGuillemet, 
                  contenue=$description,categorie_id=$category_id");
                 $_GET['id']=$mydb->lastInsertId();//récupération de l'id de ce qu'on a inserer en dernier dans la BDD
             }
              echo 'La realisations a été rajouté';


             /**
              * Envoie des images
              */
              $id_realisation=$mydb->quote($_GET['id']);
               $ImageTelecharger=$_FILES['image'];
               require '../librairie/image.php';
               $extensionImageTelecharger=pathinfo($ImageTelecharger['name'], PATHINFO_EXTENSION);
              if(in_array($extensionImageTelecharger,array('jpg','png')));//les seuls extension qu'on accepte
                {
                      //on enregistre 
                      $ver=$mydb->query("INSERT INTO images SET realisation_id=$id_realisation");//on insert l'image sans son non et aussitôt on update cette enregistrement
                      $image_id=$mydb->lastInsertId();
                      //enregistrer l'image dans un dossier
                      $nomimageAEnregistrer= $image_id.'.'.$extensionImageTelecharger;
                      $nomimageAEnregistrer=$mydb->quote($nomimageAEnregistrer);
                      move_uploaded_file($ImageTelecharger['tmp_name'],IMAGES.'/realisation/'.$image_id.'.'.$extensionImageTelecharger);
                      //ou   move_uploaded_file($ImageTelecharger['tmp_name'],'C:\wamp64\www\portfolio\lesPages\site\img\realisation/'.$image_id.'.'.$extensionImageTelecharger);
                      resizeImage(IMAGES.'/realisation/'.$image_id.'.'.$extensionImageTelecharger,150,150);
                      $mydb->query("UPDATE images SET NomImage=$nomimageAEnregistrer WHERE id=$image_id");
                }
            
      }
      else{
            echo "Le slug n'est pas valide";
            header('Location:'. WEBROOT. 'admin/realisation.php');
              die();
           }
      
}

/**
 * Edition de la catégorie
 */
if(isset($_GET['id']))
{
     
      $id=$mydb->quote($_GET['id']);
      $requete=$mydb->query("SELECT * FROM realisations WHERE id=$id");//retoure le resultat de la requete
      if($requete->rowCount()==0)
     {
            echo "il n'y a pas de realisations avec cet ID";
            header('Location:'. WEBROOT. 'admin/categorie.php');
            die();
      }
         
           
                   
}
//requete pour faire la liste redoulante
$requetePourMettreCategorieDansLaListeDeroulante=$mydb->query("SELECT name, id FROM categories ORDER BY name ASC");
$categories=$requetePourMettreCategorieDansLaListeDeroulante->fetchAll(PDO::FETCH_OBJ);

//recupération des images pour les afficher à côté et je les affiche dans le formulaire l'avant dernier <div>
if(isset($_GET['id']))
{
      $idRealisation=$mydb->quote($_GET['id']);
      $requeteImage=$mydb->query("SELECT id, NomImage FROM images where realisation_id =$idRealisation") ;
      $imagesRealisation=$requeteImage->fetchAll(PDO::FETCH_OBJ);      
}
else{// si on a pas d'images
      $imagesRealisation=array();
}

/**
 * suppression d'une image
 */
if(isset($_GET['delete_image']))
{     checkcsrf();
      $idRea=$mydb->quote($_GET['delete_image']);
      $requete=$mydb->query("SELECT NomImage,realisation_id FROM images WHERE id=$idRea");
      $images=$requete->fetchAll(PDO::FETCH_OBJ);
      foreach( $images as $valeur)//cette boucle n'est éxécuter qu'une seul fois c'est à cause du fetchAll(PDO::FETCH_OBJ)
      {
            $cheminImageASupprimer=glob(IMAGES.'/realisation/'.pathinfo($valeur->NomImage,PATHINFO_FILENAME).'_*x*.*');//*x*.* veut dire nom qui commencence par  // n'importe quel carcarete suivit de X suivit de n'importe quel caractere suivit de "." et suivit de n'importe quel autre caractére ie l'extension                                                                                           
            if(is_array($cheminImageASupprimer))//si c'est un tableau
            {
                  foreach( $cheminImageASupprimer as $contenue)
                  {
                        unlink($contenue);
                  }
            }
      }
      foreach($images as $image){ //cette boucle ne va s'éxécuter qu'ue seul fois car on recupere avec l'ID. il 
                                    //est utiliser car le fetchAll(PDO::FETCH8OBJ) on doit passer par un objet (ici image sans "s")
            unlink(IMAGES.'/realisation/'.$image->NomImage);//suppression de l'image
            $mydb->query("DELETE FROM images WHERE id =$idRea");
      echo "l'image a bien été supprimé";
      header('Location:realisation.php?id='.$image->NomImage);
      die();
      }
      
}

/**
 * Mis à avant d'une image
 */
if(isset($_GET['hightlight_image']))
{     checkcsrf();
      $idRea_id=$mydb->quote($_GET['id']);
      $image_id=$mydb->quote($_GET['hightlight_image']);
      $mydb->query("UPDATE realisations SET image_id=$image_id WHERE id =$idRea_id");
      echo "L'image a bien été mis en avant";
     // header('Location:realisation.php?id='.$_GET['id']);
     // die();      
}

?>

<?php
//recuperation de l'id de la categorie correspondant à la réalisation qu'on veut 
//modifier (si on appuie sur le bouton editer).
if(isset($_GET['id']))
{
 $idrealisation=($_GET['id']);
$requete=$mydb->query("SELECT categorie_id FROM realisations WHERE id=$idrealisation");
$tableauCategorieRealisation=$requete->fetch();
$idCatRealisation=$tableauCategorieRealisation->categorie_id;
//pour le préremplissage des zone des texte si on veut les modifier
$idrealisation=($_GET['id']);
$requete2=$mydb->query("SELECT* FROM realisations WHERE categorie_id=$idCatRealisation");
$tableauRealisation=$requete2->fetch();
$slogAModifier=$tableauRealisation->slog;//c'est un tableau à 2D
$contenueAModifier=$tableauRealisation->contenue;
$NomAModifier=$tableauRealisation->name;

}
?>



<!-- le code html pour afficher les catégories-->
<h1>Editer la réalisation </h1>
<div class="row">
   <div class ="col-sm-8">
    
   <form action="#" method="post" enctype="multipart/form-data"><!--le # veut dire que je redirige vers la page où je suis déja et enctype="multipart/form-data pour que le formulaire prend en compte les fichiers -->
  <div class="form-group">
     <label for="name">Nom de la réalisation </label>
     <?php 
       if(isset($_GET['id'])){//si on veut modifier une réalisation existant
    echo '<input type="text" class="form-control" id="name" value='.$NomAModifier.' name="name">';//l'attribut name sert à stocker la valeur saisie dans cette variable-->
       }
       else{//sinon ie si on crée une nouvelle réalisation
            echo '<input type="text" class="form-control" id="name" value="" name="name">';
       }
       ?>
    </div> 
   <div class="form-group">
     <label for="slug">l'url de la réalisation</label>
     <?php
      if(isset($_GET['id'])){
           echo  '<input type="text" class="form-control" id="slug" value='.$slogAModifier.' name="slug">';
      }
      else{
            echo  '<input type="text" class="form-control" id="slug" value="" name="slug">';
      }
      ?>
   </div> 
   <div class="form-group">
     <label for="description">Contenue de la réalisation</label>  
     <?php
      if(isset($_GET['id'])){//si on veut modifier
            echo '<textarea type="text" class="form-control" id="description" value="" name="description">'.$contenueAModifier.'</textarea>';?>
            <script>tinymce.init({selector:'textarea'});</script>
     <?php 
   }
      else
      {
            echo '<textarea type="text" class="form-control" id="description" value="" name="description"></textarea>';
            ?>
            <script>tinymce.init({selector:'textarea'});</script> <!--pour rajouter le tinymce dan le texte area-->
  
      <?php 
    }
      ?>
   </div> 

   <div class="form-group">
   <label for="categorie_id">Catégorie</label>
   <br/>
     <select class="form-group" id="categorie_id" name="categorie_id">
     <?php
            foreach($categories as $category)
        {
              $itemAselectionner=False;
              if($idCatRealisation==$category->id)
              {
                   $itemAselectionner=true;   //on va selectionner que la catégorie correspondant à la réalisation qu'on veut modifier

                  }
                  if($itemAselectionner==true){
              echo '<option value='.$category->id.' selected>'.$category->name.'</option>';//dans ce cas si on récupére ce que l'utilissateur à selectionner, on aura le contenue qui se trouve dans value ie si on fait $_POST['categorie_id']
                  }
                  else{
                        echo '<option value='.$category->id.'>'.$category->name.'</option>';
                  }
            
        }
      ?>
      </select>
   </div> 
   <div class="form-group">
   <input type="file" name="image">
   </div>
   <button type="submit" class="btn btn-success">Enregistrer</button>
</form>   

    </div>
    <div class="col-sm-4">
            <?php foreach($imagesRealisation as $contenue):?>
            <p>
                <img src= "<?=WEBROOT;?>img/realisation/<?=$contenue->NomImage;?> " width="100">
                <a href="? delete_image=<?php echo $contenue->id; ?> &<?php echo csrf();?>"onclick=" return confirm('voulez vous supprimez l\'image');">
                  Supprimer</a> 
                 <a href="? hightlight_image=<?php echo $contenue->id; ?>& id=<?php echo $_GET['id'];?>& <?php echo csrf();?>">Mettre à la une</a><!--mettre une image à la une-->
            </p>      
            <?php endforeach ?>
    </div>

</div>


  

<?php include '../lesMorceauxDePages/piedDePage.php';
?>