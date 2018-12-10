<?php 
	ob_start();
?>
<div class="col-lg-1" id="menu-menu" style="min-width: 150px;">
    <ul class="list-group">
        <li class="list-group-item"><a href="?page=adminhome"><i class="glyphicon glyphicon-home"></i>   home</a></li>
        <li class="list-group-item"><a href="?page=qcmqcm">Créer QCM</a></li>
        <li class="list-group-item"><a href="?page=gestion_theme">Thèmes</a></li>
        <li class="list-group-item"><a href="?page=gestion_qcm">Gérer QCM</a></li>
        <li class="list-group-item active"><a href="?page=note_enseignant" style="color: #fff;">Notes</a></li>
    </ul>
</div>
<?php
	$menu = ob_get_clean();
?>
<?php
	$sql = 'SELECT DISTINCT `fk_res_utilisateur` FROM `qcm_resutat` WHERE 1';
	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute();

	$liste_des_etudiant_qcm = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
	foreach ($liste_des_etudiant_qcm as $key => $etudiant) {
		# code...
		$liste_des_etudiant_qcm[$key]['qcm'] = array();

		$sql = 'SELECT * FROM `qcm_resutat`, `qcm_utilisateur`, qcm_qcm WHERE `qcm_qcm`.qcm_id = `qcm_resutat`.fk_res_qcm AND `qcm_resutat`.`fk_res_utilisateur` = `qcm_utilisateur`.uti_id AND  uti_id = :user_id';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(['user_id' => $etudiant['fk_res_utilisateur']]);

		$qcm_info = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

		foreach ($qcm_info as $keyy => $une_info) {
			# code...
			$liste_des_etudiant_qcm[$key]['user_name'] = ucfirst($une_info['uti_nom']) . ' ' . ucfirst($une_info['uti_prenom']);

			if(isset($liste_des_etudiant_qcm[$key]['qcm'])) {

				$nb_question_max = 0;

				// nombre de questions max
				$sql = 'SELECT count(*) as nb_question FROM `qcm_construction` WHERE `fk_con_qcm` = :qcm';
				$prepared_request = $pdo->prepare($sql);
				$prepared_request->execute(["qcm" => $une_info['qcm_id']]);

				$nombre_de_question = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
				if(count($nombre_de_question) > 0) {

					$nb_question_max = $nombre_de_question[0]['nb_question'];
				}

				array_push($liste_des_etudiant_qcm[$key]['qcm'], array('libelle' => $une_info['qcm_libelle'], 'note' => $une_info['res_note'], 'nb_question' => $nb_question_max));
			}
		}
	}
?>
<?php
	ob_start();
?>
	<tr>
        <td colspan="2" style="color: red;border-bottom: 1px black;text-align: center;">Notes des Etudiants </td>
    </tr> 

    <tr style="border-bottom: solid 1px #e0e0e0;">	
    	<td style="font-weight: bold;border-right: solid 1px #e0e0e0;" align="left">Etudiant</td>
    	<td style="font-weight: bold;text-align: left;" align="left">Resultat</td>
    </tr>

    <?php
    foreach ($liste_des_etudiant_qcm as $key => $etudiant) {
     	// --
     	?>
        <tr style="border-bottom: solid 1px #e0e0e0;">
        	<td class="text-info"><?php echo $etudiant['user_name']; ?></td>
        	<td>
                <table class="table table-dark table-sm">
                    <tbody>
                    	<?php
                    	foreach ($etudiant['qcm'] as $keyy => $value) {?>
	                    	<tr>
	                    		<td><?php echo ucfirst($value['libelle']); ?></td>
		                    	<td><?php echo $value['note'] . '/' . $value['nb_question']; ?></td>
		                    	<td><?php echo round(($value['note']/$value['nb_question'])*20, 1) . '/20'; ?></td>
	                    	</tr>
                    	<?php
                    	}?>
                    </tbody>
                </table>
        	</td>
        </tr>
        <?php
    }?>
<?php
	$notes = ob_get_clean();
?>