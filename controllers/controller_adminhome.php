<?php
	
	if(isset($utilisateur))
	{
		if($utilisateur->getRole()->getId() == 1)
			header('Location: ?page=home'); 
	}

	// base repertory name 
	$repertory = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR; 
	// inclusion du controleur de la page
	require( $repertory . 'models' . DIRECTORY_SEPARATOR . 'model_adminhome.php'); 
	require( $repertory . 'views' . DIRECTORY_SEPARATOR . 'view_adminhome.php'); 
?> 
