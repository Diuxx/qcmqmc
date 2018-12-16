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
			$sql = 'DELETE FROM `qcm_construction` WHERE `fk_con_qcm` = :id';

			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute( array(':id' => $id));

			$sql = 'DELETE FROM `qcm_qcm` WHERE `qcm_id` = :id';
			
			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute( array(':id' => $id));

			// tout c'est bien passé on valide la transaction
			$pdo->commit();
		} catch(Exception $e) {
			$pdo->rollback();
			throw $e;
		}

		$sql = 'SELECT * FROM `qcm_qcm` WHERE `qcm_id` = :id';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute( array(':id' => $id));

		if(count($prepared_request->fetchAll(PDO::FETCH_ASSOC)) == 0) {
			echo json_encode(['1' => 'Le QCM a bien été supprimé !']);
			exit;
		}

		echo json_encode(['2' => 'Une erreur est survenue lors de la suppression du QCM !']);
		exit;
	}
	echo json_encode(['2' => 'Impossible de supprimer le QCM (id) introuvable']); // message que la page
	exit;

?>