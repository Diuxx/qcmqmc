<?php

	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';// SELECT * FROM `qcm_qcm` WHERE `qcm_libelle` = "test DQL"

	if(isset($_POST['id']) && isset($_POST['date'])) {

		$id = $_POST['id'];
		$date = $_POST['date'];

		$sql = 'UPDATE `qcm_qcm` SET `qcm_fdate`=:datee WHERE `qcm_id` = :id';

		$data = [ // donnée à envoyer dans la base de données
			'datee' => $date,
			'id' => $id
		];

		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute($data);

		if( $prepared_request->rowCount()) {
			echo json_encode(['2' => 'La date du qcm à bien été modifié !']);
			exit;			
		}
		echo json_encode(['1' => 'Impossible de modifer la date du qcm']);
		exit;		
	}
	echo json_encode(['1' => 'Impossible de modifer la date du qcm']);
	exit;
?>