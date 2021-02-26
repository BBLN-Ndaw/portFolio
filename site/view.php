 <?php $authentification=0;//pourcette page, on a pas besoin de se connecter pour le voir donc on met la variable $authentification à zero.et puisque dans le fichier include.php on a inclus aussi le fichier auth.php alors la verfication de l'authentification sera fausse et la on ne sera pas rediriger vers la page de connection ie login.php
 ?>
 <?php include 'librairie/include.php';?>
 <?php include 'librairie/image.php';?>
<?php

/**
* recuperation de la realisation qu'on a cliqué
*/
if(!isset($_GET['slog']))
{
	header("HTTP/1.1 301 Moved Permanently");//pour dire que c'est un deplacement permanent et que google n'a pas besoin d'undexé cette page là.
    header('Location:index.php');
    die();
}
//$id_realisation=$mydb->quote($_GET['id']);
$SLogrealisation=$mydb->quote($_GET['slog']);
$requeteReaImageClique=$mydb->query("SELECT* FROM realisations WHERE slog =$SLogrealisation");
if($requeteReaImageClique->rowCount()==0)
{
	header("HTTP/1.1 301 Moved Permanently");
    header('Location:index.php');
    die();
}
$realisationsDeLiamgeClique=$requeteReaImageClique->fetch();
$id_realisation=$realisationsDeLiamgeClique->id;
$requeteImagesRea=$mydb->query("SELECT* FROM images WHERE realisation_id =$id_realisation");
$LesiamgeDeLaRealisation=$requeteImagesRea->fetchAll();
?>

<?php
//affichage du titre
$title=$realisationsDeLiamgeClique->name;
 include 'lesMorceauxDepages/header.php';
 ?>







  <h1><?= $realisationsDeLiamgeClique->name;?></h1> 
 <!--affichage du contenue de la realisation correspondant à l'image cliqué-->

<?= $realisationsDeLiamgeClique->contenue;?>

<!--affcihage des images-->
	<?php foreach ($LesiamgeDeLaRealisation as $image):?> 
	   <p>
	   	 <img src="<?= WEBROOT;?>img/realisation/<?=$image->NomImage;?>" width="100%">
	   </p>
	<?php endforeach ?>
	
</div>





 <?php //include 'librairie/debug.php';?>
 <?php include 'lesMorceauxDepages/piedDePage.php';?>