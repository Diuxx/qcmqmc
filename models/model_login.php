<?php 
	// connection de l'utilisateur à la platforme
	$identifiant = ''; // login
	$soleil = ''; // mot de passe

	// gère les erreurs de login
	$error = false;

	// login de l'utilisateur
	if(isset($_POST['identifiant']) && isset($_POST['soleil']))
	{
		$identifiant = $_POST['identifiant'];
		$soleil = $_POST['soleil'];

		$utilisateur = new Utilisateur();
		$utilisateur->connect($identifiant, $soleil);

		// test si l'utilisateur est connecté.
		if($utilisateur->estConnecter()) {
			// enregistrement de l'id de l'utilisateur en variable de session
			$_SESSION['uid'] = $utilisateur;

			// redirection vers les page bonnes
			if($utilisateur->getRole()->getId() == 2) {
				$session->redirect('?page=adminhome');
			} else {
				$session->redirect('?page=home');
			}
		} else {
			$error = true;
			$message = "<b>Erreur:</b> Nom d'utilisateur ou mot de passe incorrect.";
		}
	}
	ob_start();
?> 
	<?php 
		if($error) {
			?>
			<div class="alert alert-danger">
			  	<?php echo $message; ?>
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-warning">
		  		<strong>Veuillez vous authentifier.</strong>
			</div>
			<?php		
		}
	?>
<?php
	$message_authentification = ob_get_clean();
?>