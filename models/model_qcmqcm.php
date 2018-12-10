<?php 
	ob_start();
?>
<div class="col-lg-1" id="menu-menu" style="min-width: 150px;">
    <ul class="list-group">
        <li class="list-group-item"><a href="?page=adminhome"><i class="glyphicon glyphicon-home"></i>   home</a></li>
        <li class="list-group-item active"><a href="?page=qcmqcm" style="color: #fff;">Créer QCM</a></li>
        <li class="list-group-item"><a href="?page=gestion_theme">Thèmes</a></li>
        <li class="list-group-item"><a href="?page=gestion_qcm">Gérer QCM</a></li>
        <li class="list-group-item"><a href="?page=note_enseignant">Notes</a></li>
    </ul>
</div>
<?php
	$menu = ob_get_clean();
?>
<?php
	$date = date('Y-m-d');

	// pour modifier un qcm on utilise cette page avec les donnée du qcm
	if(isset($_POST['modifier'])) {
		$qcm_id = $_POST['modifier'];
		//echo 'id : ' . $qcm_id;

		// requete recherchant toutes les question du qcm
		$sql = 'SELECT * FROM `qcm_construction`, `qcm_question` WHERE `qcm_construction`.`fk_con_question` = `qcm_question`.`que_id` AND `fk_con_qcm` = :id';

		// id du qcm
		$attr = array(
			':id' => $qcm_id
		);

		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute($attr);

		// variable que l'on réutilisera dans notre vue.
		$lesQuestions = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		// récupération de la date du qcm
		$sql = 'SELECT `qcm_fdate` FROM `qcm_qcm` WHERE `qcm_id` = :id';
		
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute([':id' => $qcm_id]);
		$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		if( count($result) == 1) {
			$date = $result[0]['qcm_fdate'];
		}//var_dump($date);var_dump($lesQuestions);

		$sql = 'SELECT `qcm_libelle` FROM `qcm_qcm` WHERE `qcm_id` = :id';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute([':id' => $qcm_id]);
		$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		if( count($result) == 1) {
			$libelle = $result[0]['qcm_libelle'];
		}

	}
?>