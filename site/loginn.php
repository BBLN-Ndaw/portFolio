 <?php
 echo var_dump($_POST['mdp']);
 echo var_dump($_GET['mdp']);?>
 <form action="#" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="login">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="login" >
  </div>
  <div class="form-group">
    <label for="mdp">Password</label>
    <input type="text" class="form-control" id="mdp">
  </div>
  <button type="submit" class="btn btn-primary">Se connecter</button>
</form>