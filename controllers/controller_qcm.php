<?php 
	
	if(isset($utilisateur))
	{
		if($utilisateur->getRole()->getId() == 2)
			header('Location: ?page=adminhome');
	}	

	// base repertory name 
	$repertory = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;

	// inclusion du controleur de la page 
	require( $repertory . 'models' . DIRECTORY_SEPARATOR . 'model_qcm.php'); 
	require( $repertory . 'views' . DIRECTORY_SEPARATOR . 'view_qcm.php'); 
?> 
