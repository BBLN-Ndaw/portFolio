 <?php $authentification=0;//pourcette page, on a pas besoin de se connecter pour le voir donc on met la variable $authentification à zero.et puisque dans le fichier include.php on a inclus aussi le fichier auth.php alors la verfication de l'authentification sera fausse et la on ne sera pas rediriger vers la page de connection ie login.php
 ?>
 <?php include 'librairie/include.php';?>
 <?php include 'librairie/image.php';?>
<?php

$category=false;
$category_id=0;
// verification des categories : si on cliqué sur une catgorie
if(isset($_GET['slug']))
{
	$slug=$mydb->quote($_GET['slug']);
	$requeteCategorie=$mydb->query("SELECT* FROM categories WHERE slug=$slug");
	if($requeteCategorie->rowCount()==0)
	{
	  header("HTTP/1.1 301 Moved Permanently");
      header('Location:index.php');
      die();
	}
	//else il n'est pas important car si ça rentre dans le if, il sera arreter par le die().
	//{
		$category=$requeteCategorie->fetch(PDO::FETCH_OBJ);
		$category_id=$category->id;

	//}
}



/**
* selection des realisations qui correcreponde à l'image et à la categorie
*/
$requete=$mydb->query("SELECT realisations.id as id_realisation, realisations.name, realisations.slog, images.NomImage as images_name   FROM realisations
 LEFT JOIN images ON images.id= realisations.image_id 
 LEFT JOIN categories ON realisations.categorie_id=$category_id");
$realisations=$requete->fetchAll();


/**
* selection des differentes catégories
*/
 $requeteCategorie=$mydb->query("SELECT * FROM categories");
 $categories=$requeteCategorie->fetchAll();




 //si on detecte une categorie
 //affcihe la categorie de la realisation en grand titre quand on y clique
 if($category)
 {
    $title="Mes réalisation en $category->name";

 }
 else
 {
 	$title="Bienvenue sur mon portfolio";
 }

?>


<!-- debut du html-->

<?php include 'lesMorceauxDepages/header.php';?>
<div class="infoPersonels">
	<span id="salut">Je suis, </span>
	<p>&nbsp</p>
	<h1 id="nom-prenom"> Yaya NDAW</h1>
	<br>
	<h5 id="presentation"> Etudiant en <span id="master">Master 2 MIAGE FA</span> à l'université de Paris</h5>
	<p id="passion"> je suis passionné par les nouvelles technologies et la gestion d’entreprises pour leur évolution.</p>
</div>
<!--espacement-->
<p>&nbsp</p>
<p>&nbsp</p>
<!-- affichage du nom de la categorie en grand titre quand on y clique-->
 <h1><?= $title;?></h1>	
</br></br>

 
<!--affcihage des realisations-->

<dvi class="row"> <!--un bloc sur une ligne-->
	<div class="col-sm-8"><!--8 colonnes sur la ligne-->
		<div class="row">
	<?php foreach ($realisations as $realisation):?> 
		<div class="col-sm-3">
			<a href="<?=WEBROOT;?>realisation/<?=$realisation->slog;?>">
				<img src="<?= WEBROOT;?>img/realisation/<?= resisedName($realisation->images_name,150,150);?>" alt="">
				<h2> <?php echo $realisation->name;?></h2>
			</a>
		</div>
	<?php endforeach ?>
	
</div>
	</div> 
	<!--affcihages des categories-->
	<div class="col-sm-4">
		<ul>
			<p> <h4>Catégories des réalisations</h4></p>
			<?php foreach ($categories as $categorie): ?>
              <li>
              	<h2>
              	<a href="<?=WEBROOT;?>categorie/<?=$categorie->slug;?> ">
              		 <?php echo $categorie->name;?>
              	</a>
              </h2>
              </li>
				
			<?php endforeach ?>
		</ul>
	</div>
</dvi>





 <?php// include 'librairie/debug.php';?>
 <?php include 'lesMorceauxDepages/piedDePage.php';?>