<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';
	
	// tableau contenant les questions
	$array = array();
	$sql = 'SELECT * FROM `qcm_qcm` WHERE 1';

	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute();

	$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($result);
?>