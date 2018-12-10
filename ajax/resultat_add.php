<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';


	if(isset($_POST['qcm_id']) && isset($_POST['user_id']) && isset($_POST['note'])) {

		// information à inserer dans la base de données
		$qcm_id = $_POST['qcm_id'];
		$user_id = $_POST['user_id'];
		$note = $_POST['note'];
		$id = uniqid();

		$attr = array(
			':id' => $id,
			':note' => $note,
			':qcm' => $qcm_id,
			':user' => $user_id
		);			

		try {
			// debut de la discution avec se serveur sql
			$pdo->beginTransaction();
			$sql = 'INSERT INTO `qcm_resutat`(`res_id`, `res_note`, `fk_res_qcm`, `fk_res_utilisateur`) VALUES (:id,:note,:qcm,:user)';
			$prepared_request = $pdo->prepare($sql);

			$prepared_request->execute($attr);
			// tout c'est bien passé on valide la transaction
			$pdo->commit();
		} catch(Exception $e) {
			$pdo->rollback();
			throw $e;
			exit;
		}
		echo json_encode(['2' => 'La note a bien été enregisté !']);
		exit;
	}
	echo json_encode(['2' => "Impossible de noter l'etudiant"]);
	exit;
?>