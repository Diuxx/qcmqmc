<?php
	// l'url du site internet est xxx.com?page=(page)
	if(!isset($_GET['page']))
	{
		header('Location: index.php?page=home');
	}
	
	// affectation de la variable page
	$page = (isset($_GET['page'])) ? $_GET['page']: '';
	//echo 'debug : controleurs/' . $page . '.php';

	// connection à la base de données
	require('config.php');

	// class relative aux tables de la bdd
	require('class/class_user.php');
	require('class/class_session.php');
	require('class/class_role.php');

	// désactivation de l'en tete pour des cas particulier (api)
	$page_special = array('qcm');
	$disable_html = (in_array($page, $page_special)) ? 'true' : 'false';

	// début de la session si elle n'existe pas déja
	$session = new Session();
	if(!isset($_SESSION['uid'])) {
		// login si personne de connecté
		if($page != 'register')
			$page = 'login';
	} else {
		if(!isset($utilisateur))
			$utilisateur = $_SESSION['uid'];
		// déconnection de l'utilisateur;
		if(isset($_POST['deco']))
		{
			$utilisateur->deconnection();
			$session->redirect('?page=index');
		}
	}

	// gestion de l'affichage de la page
	if($disable_html == 'false') 
		require('views/view_template_head.php');

	// inclusion du contrôleur si il existe
	if(!empty($page) && is_file('controllers/controller_' . $page . '.php'))
	{
		require('controllers/controller_' . $page . '.php');
	} 
	else {
		require('controllers/controller_home.php');
	}

	// pied de la page
	if($disable_html == 'false') 
		require('views/view_template_foot.php');
?>