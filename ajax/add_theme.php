<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';

	if(isset($_POST['theme'])) {

		$theme = strtolower($_POST['theme']);
		$sql = 'SELECT * FROM `qcm_theme` WHERE `the_libelle` = :theme';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute([':theme' => $theme]);
		// recuperation des resultat
		$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			//http_response_code(500); // err here
			echo json_encode(['1' => 'Le thème (' . $theme . ') exist déjà dans la base de données.']);
			exit;			
		} else {
			try {
				// debut de la discution avec se serveur sql
				$pdo->beginTransaction();
				$sql = 'INSERT INTO `qcm_theme`(`the_libelle`) VALUES (:theme)';
				$prepared_request = $pdo->prepare($sql);

				$prepared_request->execute([':theme' => $theme]);
				// tout c'est bien passé on valide la transaction
				$pdo->commit();
			} catch(Exception $e) {
				$pdo->rollback();
				throw $e;
				exit;
			}
			echo json_encode(['2' => 'Le thème (' . $theme . ') a bien été ajouté à la base de données.']);
			exit;
		}
	} 
	//http_response_code(500); // err here
	echo json_encode(['1' => 'Le thème est introuvable.']);
	exit;	
?>