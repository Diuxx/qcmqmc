<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';
	
	// tableau contenant les questions
	$array = array();
	//$sql = 'SELECT * FROM `qcm_theme` WHERE 1';
	$sql = 'SELECT * FROM `qcm_theme` WHERE 1';

	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute();

	$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
	$lesThemes = array();
	foreach ($result as $key => $theme) {
		// le theme en cours de d'analyse
		$unTheme = $theme['the_id'];

		$sql = 'SELECT count(*) as nb_question FROM `qcm_question` WHERE `fk_theme` = :unTheme';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(['unTheme' => $unTheme]);
		$nb_question_pour_theme = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		if(count($nb_question_pour_theme) > 0) 
		{

			$result[$key]['nb_question'] = $nb_question_pour_theme[0]['nb_question'];

		}
	}
	echo json_encode($result);
?>