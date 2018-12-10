<?php

	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';// SELECT * FROM `qcm_qcm` WHERE `qcm_libelle` = "test DQL"

	if(isset($_POST['id']) && isset($_POST['active'])) {


		$id = $_POST['id'];
		$active = $_POST['active'];

		$sql = 'UPDATE `qcm_qcm` SET `qcm_active`=:active WHERE `qcm_id` =:id';

		$data = [ // donnée à envoyer dans la base de données
			'active' => $active,
			'id' => $id
		];

		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute($data);

		if( $prepared_request->rowCount()) {
			echo json_encode(['2' => 'Le status du qcm a bien été changé']);
			exit;			
		}
		echo json_encode(['1' => "Impossible de  changer l'état du qcm"]);
		exit;		


	}
	echo json_encode(['1' => "Impossible de  changer l'état du qcm"]);
	exit;

?>