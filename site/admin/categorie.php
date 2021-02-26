<?php
include '../librairie/include.php';//dans le fichier include.php on a mis l'inclusion du fichier auth.php car cette page (categorie) ne peut être afficher que si on se connecte.
include '../lesMorceauxDepages/admin_header.php';




/**
* SUPPRESSION
*/
if(isset($_GET['delete']))
{
	checkCsrf();
	$id=$_GET['delete'];
	$select=$mydb->query("DELETE FROM categories WHERE id=$id");
	setFlah('la categorie a bien été supprimer');
	header('Location:'.WEBROOT.'admin/categorie.php');
	die();
}


/**
* traitement des categories
*/
$select=$mydb->query("SELECT id, name, slug FROM categories");
$categories=$select->fetchAll();
?>

<p>
	<a href="edit_categorie.php" class="btn btn-success">Ajouter une nouvelle Catégorie</a></p>
<h1>Les categories</h1></br>

<table class =table table-striped>
	<thead>
		<tr>
			<th>ID</th>
			<th>NOM</th>
			<th>ACTION</th>
				
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categories as $categorie): ?> 
			<tr>
				<td><?= $categorie->id; ?></td>
				<td><?= $categorie->name; ?></td>
				<td>
				<a href="edit_categorie.php ?id=<?= $categorie->id; ?>" class="btn btn-default">Edit</a>
				<a href=" ?delete=<?= $categorie->id; ?>&<?= csrf(); ?>" class="btn btn-error" onclick="return confirm('Etes vous sûr de vouloir supprimer?');">Supprimer</a>

				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
	
</table>



<?php include '../lesMorceauxDepages/piedDePage.php'?>