<?php
include '../librairie/include.php';//dans le fichier include.php on a mis l'inclusion du fichier auth.php car cette page (realisation) ne peut être afficher que si on se connecte.
include '../lesMorceauxDepages/admin_header.php';




/**
* SUPPRESSION
*/
if(isset($_GET['delete']))
{
	//checkCsrf();
	$id=$_GET['delete'];
	$select=$mydb->query("DELETE FROM realisations WHERE id=$id");
	setFlah('la realisation a bien été supprimer');
	header('Location:'.WEBROOT.'admin/realisation.php');
	die();
}


/**
* traitement des realisation
*/
$select=$mydb->query("SELECT id, name, slog FROM realisations");
$realisations=$select->fetchAll();
?>

<p>
	<a href="edit_realisation.php" class="btn btn-success">Ajouter une nouvelle Réalisation</a></p>
<h1>Les Réalisations</h1></br>

<table class =table table-striped>
	<thead>
		<tr>
			<th>ID</th>
			<th>NOM</th>
			<th>ACTION</th>
				
		</tr>
	</thead>
	<tbody>
		<?php foreach ($realisations as $realisation): ?> 
			<tr>
				<td><?= $realisation->id; ?></td>
				<td><?= $realisation->name; ?></td>
				<td>
				<a href="edit_realisation.php ?id=<?= $realisation->id; ?>" class="btn btn-default">Editer</a>
				<a href=" ?delete=<?= $realisation->id; ?>&<?= csrf(); ?>" class="btn btn-error" onclick="return confirm('Etes vous sûr de vouloir supprimer?');">Supprimer</a>

				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
	
</table>



<?php include '../lesMorceauxDepages/piedDePage.php'?>