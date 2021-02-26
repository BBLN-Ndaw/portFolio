<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
 <title>
  <?= isset($title)? $title : "Mon portfolio" //si on a une categorie, on affiche la categorie sinon on affcihe mon portfolio
  ?>
</title>
  <link rel="stylesheet" href="<?=WEBROOT;?>css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="<?=WEBROOT;?>css/gestionIndex.css" /> <!--pour les pages css-->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?= WEBROOT;?>">Mon Premiers Portfolio</a>
</nav>
<div class="container">
	<p>&nbsp</p>
<?php flash(); ?>