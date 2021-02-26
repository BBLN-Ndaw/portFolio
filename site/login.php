 <?php $authentification=0;?>
 <?php include 'librairie/include.php';?>
<?php include 'lesMorceauxDepages/header.php';?>
<?php
/**
* traitement du formulaire
*/
   if(isset($_POST['userName'])&&isset($_POST['password']))
   {
   	$userName=$mydb->quote($_POST['userName']);
   	$passWord=sha1($_POST['password']);
   	$requete=$mydb->query("SELECT * FROM users WHERE userName=$userName AND passWord='$passWord'");
		   	if($requete->rowCount()>0)
		   	{
          $utilisateurConnecter=$requete->fetch(PDO::FETCH_OBJ);
		   		$_SESSION['auth']['id']=$utilisateurConnecter->id;//on definit la session pour s'assurer par la suite que l'utilisateur a bien les droit pour acceder à cette page.
		   		setFlah('Vous êtes maintenant connecter');
		   		header('Location:'.WEBROOT.'admin/index.php');//si on se connecte cela veut dire qu'on est administrateur du coup on sera rediriger vers /admin/index.php ie la page d'accueil de l'admin.
		   		die();
		   	}
   	}
   	/**
   	* inclusion du header
   	*/
   	include 'lesMorceauxDepages/header.php';
?>
 <ul>
 	 <form action="#" method="post">
  <div class="form-group">
    <label for="userName">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="userName" name="userName" >
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
 </ul>

 <?php //include 'librairie/debug.php';?>
 <?php include 'lesMorceauxDepages/piedDePage.php';?>