<?php 
	ob_start();
?>
<div class="row">
    <div class="col-lg-1" id="menu-menu" style="min-width: 150px;">
	    <ul class="list-group">
	        <li class="list-group-item active"><a href="?page=home" style="color: #fff;"><i class="glyphicon glyphicon-home"></i>  home</li>
	        <li class="list-group-item"><a href="?page=note_etudiant">Notes</a></li>
	    </ul>
    </div>
</div>
<?php
	$menu = ob_get_clean();
?>
<?php
	// requete récupération des qcm
	$sql = 'SELECT * FROM `qcm_qcm` WHERE `qcm_active` = 1 ORDER BY `qcm_fdate` DESC';
	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute();

	$QCM = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

	// les Qcm auquel l'utillisateur a déja participé
	$sql = 'SELECT * FROM `qcm_resutat` WHERE `fk_res_utilisateur` = :user_id';
	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute(["user_id" => $utilisateur->getId()]);

	$user_notes = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

	foreach ($QCM as $key => $value) {
		# code...

		$sql = 'SELECT count(*) as nb_question FROM `qcm_construction` WHERE `fk_con_qcm` = :qcm';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(["qcm" => $value['qcm_id']]);

		$nombre_de_question = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		if(count($nombre_de_question) > 0) {

			$QCM[$key]['nb_question'] = $nombre_de_question[0]['nb_question'];
		}
	}

	// les dates sont ici utilisées au format MySQL (YYYY-mm-jj) 
	function lessThanNow($date1) { 
		$dateBuffer = explode('-', $date1); 
		$target = mktime(0, 0, 0, $dateBuffer[1], $dateBuffer[2], $dateBuffer[0]);

		$nowBuffer = explode('-', date("Y-m-d")); 
		$now = mktime(0, 0, 0, $nowBuffer[1], $nowBuffer[2], $nowBuffer[0]); 
		return ($now < $target); 
	}

	// la différence entre deux dates
	function diffDate($date) {
		$target = date_create(date("Y-m-d"));
		$now = date_create($date);
		$diff = date_diff($target, $now);
		return $diff->format('%R%a');
	}

	// flux du code html
	ob_start();
?>
<tr>
    <td colspan="4" style="color: red;border-bottom: 1px black;text-align: center;">QCM disponibles</td>
</tr> 
<!-- liste des qcm (chargement) si js d'ésactivé on gère une affichage en php -->
<?php
	foreach ($QCM as $key => $value) {
		# code...
		$in_array = false;
		$une_note = 0;
		foreach ($user_notes as $key => $uneNote) {
			# code...
			if(array_search($value['qcm_id'], $uneNote)) {
				$in_array = true;
				$une_note = $uneNote['res_note'];
			}
		}//echo 'afficher : ' . $value['qcm_id'] . ' alors [' . $in_array . ']<br>';
		if(lessThanNow($value['qcm_fdate'])) {?>
        	<tr class="success">
        		<td><?php echo ucfirst($value["qcm_libelle"]); ?></td>
        		<td>
        			<?php
        			echo $une_note . '/' . $value['nb_question'];
        			?>
        		</td>
        		<td><p class="font-weight-light"><?php echo 'Il reste ' . diffDate($value['qcm_fdate']) . ' jours'; ?></p></td>
        		<td>
        			<form method="post" action="?page=qcm">
        				<!-- cette page, il faut absolument lui envoyer des données TARGET="_BLANK"-->
        				<input class="hidden" type="text" name="titre" value=<?php echo '"' . $value['qcm_libelle'] . '"'; ?>>
        				<input class="hidden" type="text" name="qcm" value=<?php echo '"' . $value['qcm_id'] . '"'; ?>>
        				<input class="hidden" type="text" name="id" value=<?php echo '"' . $utilisateur->getId() . '"'; ?>>
        				<?php 
        				if(!$in_array) {
        					?><button type="submit" class="btn btn-info btn-xs" onclick="">Participer <span class="badge badge-light"><?php echo $value['qcm_fdate']; ?></span></button><?php
        				} else {
        					// on affiche rien
        					?><span class="label label-danger">évalué</span><?php
        				}?>
        			</form>
        		</td>
        	</tr>
		<?php
		} else {?>
        	<tr class="danger">
        		<td><?php echo ucfirst($value["qcm_libelle"]); ?></td>
        		<td>
        			<?php
        			echo $une_note . '/' . $value['nb_question'];
        			?>
        		</td>
        		<td colspan="2"><?php echo 'Clos il y a ' . diffDate($value['qcm_fdate']) . ' jours'; ?></td>
        	</tr>	                    			
		<?php
		}
	}
?>
<?php
	$list_qcm = ob_get_clean();
?>
