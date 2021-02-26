<?php
if(isset($_POST['ok'])&& isset($_POST['yy']))
{
echo "ok";
echo var_dump($_POST);
	echo "pppp";
}
else{
    echo "Nn";
}

?>

<ul>
 	 <form action="#" method="post">
  <div class="form-group">
    <label for="login">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="name" value="" name="ok" >
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" value="" id="categorie_id" name="yy">
  </div>
  <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
 </ul>