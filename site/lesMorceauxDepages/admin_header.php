<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Mon administration</title>
  <!--bootstrpp-->
  <link rel="stylesheet" href="<?= WEBROOT;?>css/bootstrap.min.css">
</head>
<body>
  <!-- le nav bar correspond au header de la page(ce qui est en haut).-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Mon Portfolio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="categorie.php">Catégorie <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="realisation.php">Réalisation</a>
      </li>
    </ul>
  </div>
</nav>   


<div class="container">

	<p>&nbsp</p>
	<p>&nbsp</p>
	<p>&nbsp</p>
<?php flash(); ?>

<script type="text/javascript" src="/monPortfolio/site/js/tinymce/js/tinymce/tinymce.min.js"></script>
