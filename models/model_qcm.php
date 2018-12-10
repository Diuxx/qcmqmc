<?php
	$titre_qcm = 'No title';

	if(isset($_POST['qcm']) && isset($_POST['id']) && isset($_POST['titre'])) {

		$titre_qcm = $_POST['titre'];
		$id_qcm = $_POST['qcm']; // id du qcm
		$user_id = $_POST['id'];

		// --
		$sql = 'SELECT * FROM `qcm_resutat` WHERE `fk_res_utilisateur`= :user_id AND `fk_res_qcm` = :qcm_id';
		$prepared_request = $pdo->prepare($sql);

		$attr = array(
			'user_id' => $user_id,
			'qcm_id' => $id_qcm
		);		

		$prepared_request->execute($attr);

		// quand l'éleve a déja été noté on le jarte
		$estDejaNote = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		if(count($estDejaNote) > 0) {
			header("Status: 301 Moved Permanently", false, 301);
			header('Location: ?page=accueil');
			exit();
		}
		// var_dump($estDejaNote);

		$sql = 'SELECT * FROM `qcm_construction`, `qcm_question` WHERE `qcm_construction`.`fk_con_question` = `qcm_question`.`que_id` AND `fk_con_qcm` = :id';// 5bee1b07cbb58
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(['id' => $id_qcm]);

		$questions = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		foreach ($questions as $key => $uneQuestion) {
			// parcours des questions du qcm
			$question_id = $uneQuestion['que_id'];// id de la question

			$sql = 'SELECT * FROM `qcm_reponse` WHERE `fk_question` = :id';
			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute(['id' => $question_id]);

			$lesResponses = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
			//array_push($questions[$key], 'reponses', $lesResponses);

			$questions[$key]['reponses'] = $lesResponses;
			//var_dump( $lesResponses);
		}
		//var_dump($questions);
	} else {
		header('Location: ?page=home');
	}
?> 
