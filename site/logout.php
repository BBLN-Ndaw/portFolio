<?php
$authentification=0;//on a pas besoin de se connecter pour voir cette page
$_SESSION=array();//pour vider la contenue de ce variable
include 'librairie/include.php';
header('Location:'.WEBROOT.'/index.php');//si je suis deconnecter je serais rediriger vers la page d'accueil
die();
?>