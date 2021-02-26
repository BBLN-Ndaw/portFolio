<?php
try {
 	$mydb=new PDO('mysql:host=localhost;dbname=portfolio','root','');
 	$mydb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);//pour ne pas à chaque fois mettre le type de mode de la requete
 	$mydb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
 	//$mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (Exception $e) {
 	echo "impossible de se connecter à la base de données";
 	die();
 	
 } 
//ce fichier sera inclus dés qu'on aura besoin de se connecter à la base  de données