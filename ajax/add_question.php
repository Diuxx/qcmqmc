<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';

	if(isset($_POST['form'])) {

		// Récupréation des informations de l'en-tête
		$form = $_POST['form'];
		$question = $form['question'];
		$theme = $form['theme'];
		$vraisfaux = $form['vraisfaux'];
		$user_id = $form['userid']; // id de l'utilisateur
		$id = uniqid(); // id de la question!

		// tableau des donnée à insérer dans la base de données
		$attr = array(':id' => $id,
					  ':question' => $question,
				  	  ':vraisfaux' => $vraisfaux,
				  	  ':auteur' => $user_id,
				  	  ':theme' => $theme);

		try {
			// debut de la discution avec se serveur sql
			$pdo->beginTransaction();
			// préparation de la requete
			$stmt = $pdo->prepare('INSERT INTO `qcm_question`(`que_id`, `que_libelle`, `que_reponse`, `fk_auteur`, `fk_theme`) VALUES (:id,:question,:vraisfaux,:auteur,:theme)');
			$stmt->execute($attr); // execution de la requete
			// tout c'est bien passé on valide la transaction
			$pdo->commit();
		} catch(Exception $e) {
			$pdo->rollback(); // sinon il ne se passe
			throw $e;
		}

		// si ce n'est pas qu'un vrais faux
		if(isset($_POST['reponse']) && isset($_POST['reponsevrais'])) {
			// --
			$reponse = json_decode($_POST['reponse']);
			$reponsevrais = json_decode($_POST['reponsevrais']);

			try {
				// debut de la discution avec se serveur sql
				$pdo->beginTransaction();
				// ajout de réponses associer à l'id de la question
				$stmp = $pdo->prepare('INSERT INTO `qcm_reponse`(`rep_libelle`, `rep_vrais`, `fk_question`) VALUES (?,?,?)');
				foreach ($reponse as $key => $value) {
					// reponsevrais est moche.
					$stmp->execute([$value, $reponsevrais[$key], $id]);
				}
				// tout c'est bien passé on valide la transaction
				$pdo->commit();
			} catch(Exception $e) {
				$pdo->rollback();
				throw $e;
			}
		}
	} else {
		// error here!
		http_response_code(500); // err here
		echo json_encode(['0' => 'error']); // message que la page
		exit;
	}

	// résultat
	echo json_encode($arrayName = array('0' => 'La question a été ajouté avec succès !'));
?>