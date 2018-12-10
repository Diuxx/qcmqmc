<?php

	/*if(isset($utilisateur))
	{
		$session->redirect(($utilisateur->getRole()->getId() == 2) ? '?page=adminhome':'?page=home');
	}*/

	// base repertory name 
	$repertory = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;

	// inclusion du controleur de la page 
	require( $repertory . 'models' . DIRECTORY_SEPARATOR . 'model_login.php'); 
	require( $repertory . 'views' . DIRECTORY_SEPARATOR . 'view_login.php'); 
?> 
