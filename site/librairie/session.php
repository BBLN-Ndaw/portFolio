<?php
function flash()
{
	if(isset($_SESSION['Flash']))
	{
		extract($_SESSION['Flash']);
		unset($_SESSION['Flash']);//detruire la ariable
	     echo '<div class="alert alert-$type" role="alert">'.$message.'</div>';
	}
}
function setFlah($message,$type='success')
{
	$_SESSION['Flash']['message']=$message;
	$_SESSION['Flash']['type']=$type;
}

?>