<?php
$authentification=0;
include '../librairie/include.php';//dans le fichier include.php on a mis l'inclusion du fichier auth.php car cette page (edit_categorie) ne peut être afficher que si on se connecte.
/**
* traitement de l'ajout de la categorie
*/
if(isset($_POST['name'])&&isset($_POST['slug']))
{
	$slug=$_POST['slug'];
	//verfication de l'expression reguliere du slug
	if(preg_match('/^[a-z\-0-9]+$/', $slug))
	{
           $name=$mydb->quote($_POST['name']);
           $slug=$mydb->quote($_POST['slug']);
           /**
           * si on a l'ID cela veuy dire qu'on veut faire une mis a jours
           */
           if(isset($_GET['id']))
           {
           	$id=$mydb->quote($_GET['id']);
           	 $mydb->query("UPDATE categories SET name=$name, slug=$slug WHERE id=$id ");
                
           }
           else//sinon cela veut dire qu'on enregistre une nouvelle categorie
           {
               $mydb->query("INSERT INTO categories SET name=$name, slug=$slug ");
           }
           setFlah('La catégorie a bien été enregistrer');
           header('Location:'.WEBROOT.'admin/categorie.php');
           die();
	}
	else
	{
		setFlah('Le  slug n\'est pas valide','danger');
	}
	

}

/**
* modification d'une categorie
*/
if(isset($_GET['id']))
{
	$id=$mydb->quote($_GET['id']);
	$requete=$mydb->query("SELECT* FROM categories WHERE id=$id");
     if($requete->rowCount()==0)//si la requete ne renvoie pas d'enregistrement
     {
            setFlash('Il n\'y a pas d catgorie avec cette ID','danger');
            header('Location:'.WEBROOT.'admin/categorie.php');
            die();
      }
      else{
           	$categorie=$requete->fetch();
           	$NomAModifier=$categorie->name;
           	$slugAMOdifier=$categorie->slug;
      }
}
?>




<?php include '../lesMorceauxDepages/admin_header.php';?>
<ul>
 	 <form action="#" method="post">
  <div class="form-group">
    <label for="name">Nom de la categorie</label>
    <?php 
             if(isset($_GET['id'])){//si on veut modifier une categorie existant
    echo '<input type="text" class="form-control" id="name" value='.$NomAModifier.' name="name">';//l'attribut name sert à stocker la valeur saisie dans cette variable-->
       }
       else{//sinon ie si on crée une nouvelle categorie
            echo '<input type="text" class="form-control" id="name" value="" name="name">';
       }
       ?>
  </div>
  <div class="form-group">
    <label for="slug">L'url de la categorie</label>
    <?php
      if(isset($_GET['id'])){
           echo  '<input type="text" class="form-control" id="slug" value='.$slugAMOdifier.' name="slug">';
      }
      else{
            echo  '<input type="text" class="form-control" id="slug" value="" name="slug">';
      }
      ?>
  </div>
  <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>






<?php include '../lesMorceauxDepages/piedDePage.php'?>