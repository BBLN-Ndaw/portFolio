<?php
session_start();
if(!isset($authentification))//si la page neccessite une connexion. si une page ne cessecite pas une connexion alors la variable $authentification sera égale à zero. ici on verifie qu'il n'existe pas et qu'il n'est pas égale à zéro dans le cas ou il existerait.
{
if(!isset($_SESSION['auth']['id']))//si l'utilisateur veut acceder à une page alors qu'il ne s'est pas connecter alors o le retourne vers la page de connection.
{
	header('Location:'.WEBROOT.'login.php');
}
}
if (!isset($_SESSION['csrf'])) {
	$_SESSION['csrf']=md5(time()+rand());
}
/**
* on met un csrf pour que si quelqu'un charge la page d'edition ou de suppression de categories qu'il puisse pas voir l'id des table et faire des suppression par exemple. donc il faut l'appeler au moment du passage de variable dans l'url
*/
function csrf()
{
	return 'csrf='. $_SESSION['csrf'];
}
/**
*cette fonction doit être appelle à chaque fois qu'on veut supprimer quelques choses afin de s'assurer que c'est pas un hacker qui veut executer une requete de suppression.
*/
function checkCsrf()
{
	if(!isset($_GET['csrf'])||($_GET['csrf']!= $_SESSION['csrf']))
	{
		header('Location:'.WEBROOT.'csrf.php');
		die();
	//quand on veut récuperer dans l'url quelques choses qui n'est pas envoyé par un formulaire (dans lequel on a choisit la methode POST) alors seul $_GET permet de récuperer ce est passer à l"url.
		
	}
}
//obligatoir si on veut utiliser les sessions sinon ça marche pas.
// permet au utilisateur de s'authetifier. si on veut qu'une page ne soit pas accessible aux autrees, ce fichier sera inclus et on mettre $authentification=0 si laage ne neccessite pas une authentification. dans les deux cas le fichier sera inclus. -->
//si on veut qu'une variable soit accessible dans tous les pages il faut le mettre dans la variable $_SESSION
//si la variable $_SESSION['id'] existe cela veut dire que la personnes c'est connecter sinon on le dirige vers une page de connexion