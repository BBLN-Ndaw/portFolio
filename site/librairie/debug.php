<div class="row">
    <div class="col-sm-4">
    	<h2> SERVEUR</h2>
    	<?php var_dump($_SERVER);?>
    </div>
    <h2>CONSTANTE</h2>
    <div class="col-sm-4">
    	<?php var_dump(get_defined_constants());?>
    </div>
    <h2>SESSION</h2>
    <div class="col-sm-4">
    	<?php var_dump($_SESSION); ?>  	
    </div>
</div>
