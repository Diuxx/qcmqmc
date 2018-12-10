<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';


	if(isset($_POST['id'])) {
		// --
		$id = $_POST['id'];

		try {
			// debut de la discution avec se serveur sql
			$pdo->beginTransaction();
			$sql = 'DELETE FROM `qcm_reponse` WHERE `fk_question` = :id';

			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute( array(':id' => $id));

			$sql = 'DELETE FROM `qcm_question` WHERE `que_id` = :id';
			
			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute( array(':id' => $id));

			// tout c'est bien passé on valide la transaction
			$pdo->commit();
		} catch(Exception $e) {
			$pdo->rollback();
			throw $e;
		}
		echo json_encode(['1' => 'Question supprimé !']);
		exit;
	} 
	// error here!
	http_response_code(500);
	echo json_encode(['0' => 'Impossible de supprimer la question (id) introuvable']); // message que la page
	exit;
?>

