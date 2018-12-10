<?php
	header('content-type:application/json');

	// connection à la base de données
	require_once '../config.php';// SELECT * FROM `qcm_qcm` WHERE `qcm_libelle` = "test DQL"

	if(isset($_GET['titre']) && isset($_GET['auteur']) && isset($_GET['date']) && isset($_GET['active'])) {

		$titre = $_GET['titre'];
		$auteur = $_GET['auteur'];

		// transformation de la date convertirDateFrancaisVersAnglais($date)
		$date = $_GET['date'];
		//$date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));

		// echo $date; //debug on affiche rien sinn pas de prbl

		//$date = convertirDateFrancaisVersAnglais($_GET['date']);//$_GET['date'];
		$active = $_GET['active'];
		$id = uniqid(); // id du qcm

		$sql = 'SELECT * FROM `qcm_qcm` WHERE `qcm_libelle` = :titre';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute([':titre' => $titre]);
		// recuperation des resultat
		$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		if(count($result) > 0) {
			echo json_encode(['1' => 'Le titre de QCM (' . $titre . ') exist déjà dans la base de données.']);
			exit;			
		}
			// --
			try {

				$attr = array(
					':id' => $id,
					':libelle' => $titre,
					':active' => $active,
					':datee' => $date,
					':utilisateur' => $auteur
				);
				//var_dump($attr);

				// debut de la discution avec se serveur sql
				$pdo->beginTransaction();
				$sql = 'INSERT INTO `qcm_qcm`(`qcm_id`, `qcm_libelle`, `qcm_active`, `qcm_fdate`, `fk_qcm_utilisateur`) VALUES (:id,:libelle,:active,:datee,:utilisateur)';
				$prepared_request = $pdo->prepare($sql);

				$prepared_request->execute($attr);
				// tout c'est bien passé on valide la transaction
				$pdo->commit();
			} catch(PDOException $e) {
				$pdo->rollback(); //echo $e->getMessage();
				echo json_encode(['1' => $e->getMessage()]);
				exit;
			}		

			// si il y a des question associé au questionnaire
			if(isset($_GET['question']))
			{
				$question = json_decode($_GET['question']);
				//var_dump($question); INSERT INTO `qcm_construction`(`con_id`, `fk_con_question`, `fk_con_qcm`) VALUES ([value-1],[value-2],[value-3])
				try {
					// debut de la discution avec se serveur sql
					$pdo->beginTransaction();
					// ajout de réponses associer à l'id de la question
					$stmp = $pdo->prepare('INSERT INTO `qcm_construction`(`fk_con_question`, `fk_con_qcm`) VALUES (?,?)');
					foreach ($question as $key => $value) {
						$stmp->execute([$value, $id]);
					}
					// tout c'est bien passé on valide la transaction
					$pdo->commit();
				} catch(PDOException $e) {
					$pdo->rollback();
					echo json_encode(['1' => $e->getMessage()]);
					exit;
				}
			}

		echo json_encode(['2' => 'Le QCM (' . $titre . ') à été crée.']);
		exit;	
	}
	echo json_encode(['1' => 'Impossible de créer le QCM.']);
	exit;

	/**
	 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
	 * @param $date au format  jj/mm/aaaa
	 * @return string la date au format anglais aaaa-mm-jj
	*/
	function convertirDateFrancaisVersAnglais($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		return date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
	}
?>