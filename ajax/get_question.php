<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';
	
	$theme = '"%"';
	if(isset($_POST['theme'])) {
		// --
		$theme = $_POST['theme'];
	}

	// tableau contenant les questions
	$array = array();
	$sql = 'SELECT * FROM `qcm_theme`, qcm_question, qcm_utilisateur
			WHERE `qcm_theme`.the_id = `qcm_question`.fk_theme 
			AND `qcm_question`.fk_auteur = `qcm_utilisateur`.uti_id 
			AND `qcm_question`.fk_theme LIKE ' . $theme . ' ORDER BY `que_id` desc';

	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute();

	$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
	// recherches des réponses
	foreach ($result as $q) {
		$question = array();
		$question['question'] = array(
			'id' => $q['que_id'],
			'libelle' => $q['que_libelle'],
			'vrais' => $q['que_reponse']
		);
		$question['theme'] = array(
			'id' => $q['the_id'],
			'libelle' => $q['the_libelle']
		);
		$question['auteur'] = array(
			'id' => $q['uti_id'],
			'nom' => $q['uti_nom'],
			'prenom' => $q['uti_prenom']
		);
		// récuperation des réponses associé
		$sql = 'SELECT * FROM `qcm_reponse` WHERE `fk_question` = "' . $q['que_id'] . '"';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute();
		$result_reponse = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		// ajout des reponses associer à la question si ils existent
		if(sizeof($result_reponse) > 0) {
			$question['reponse'] = $result_reponse;
			//var_dump($re*)
		}
		
		$array[] = $question;
	}

	echo json_encode($array);
?>