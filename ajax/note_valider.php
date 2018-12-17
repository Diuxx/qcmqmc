<?php

	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';// SELECT * FROM `qcm_qcm` WHERE `qcm_libelle` = "test DQL"

	if(isset($_POST['id'])) {

		$id = $_POST['id'];

		$sql = 'UPDATE `qcm_resutat` SET `res_valide` = 1 WHERE `res_id` = :id';

		$data = [ // donnée à envoyer dans la base de données
			'id' => $id
		];

		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute($data);

		if( $prepared_request->rowCount()) {
			echo json_encode(['2' => 'La note du qcm a été validé']);
			exit;			
		}
		echo json_encode(['1' => 'Impossible de valider la note du qcm']);
		exit;		
	}
	echo json_encode(['1' => 'Impossible de valider la note du qcm']);
	exit;
?>