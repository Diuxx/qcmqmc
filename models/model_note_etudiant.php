<?php 
	ob_start();
?>
<div class="row">
    <div class="col-lg-1" id="menu-menu" style="min-width: 150px;">
	    <ul class="list-group">
	        <li class="list-group-item"><a href="?page=home"><i class="glyphicon glyphicon-home"></i>  home</li>
	        <li class="list-group-item active"><a href="?page=note_etudiant" style="color: #fff;">Notes</a></li>
	    </ul>
    </div>
</div>
<?php
	$menu = ob_get_clean();
?>
<?php
	// notes de l'étudiant
	$sql = 'SELECT * FROM `qcm_resutat`, `qcm_qcm` WHERE `fk_res_qcm` = `qcm_id` AND `fk_res_utilisateur` = :user_id';
	$prepared_request = $pdo->prepare($sql);
	$prepared_request->execute(['user_id' => $utilisateur->getId()]);

	$note_de_etudiant = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
	//print_r($note_de_etudiant);

	foreach ($note_de_etudiant as $key => $value) {
		# code...

		$sql = 'SELECT count(*) as nb_question FROM `qcm_construction` WHERE `fk_con_qcm` = :qcm';
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(["qcm" => $value['qcm_id']]);

		$nombre_de_question = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		if(count($nombre_de_question) > 0) {

			$note_de_etudiant[$key]['nb_question'] = $nombre_de_question[0]['nb_question'];
		}
	}
?>
<?php 
	ob_start();
?>
	<tr>
	    <td colspan="4" style="color: red;border-bottom: 1px black;text-align: center;">Notes de l'étudiant  <?php echo ucfirst($utilisateur->getPrenom()) . ' ' . ucfirst($utilisateur->getNom()); ?>  </td>
	</tr> 

	<tr>	
		<td style="font-weight: bold;">Qcm</td>
		<td style="font-weight: bold;">validé</td>
		<td style="font-weight: bold;">Nombre de réponses correctes</td>
		<td style="font-weight: bold;">Note</td>
	</tr>
	<?php
	 foreach ($note_de_etudiant as $key => $value) {
	 	// --
	 	?>
	 	<tr>	
	    	<td><?php echo ucfirst($value['qcm_libelle']); ?></td>
	    	<td>
	    		<?php
	    			if($value['res_valide'] == 0) {
	    				?> <span class="label label-danger">non validé</span><?php
	    			} else {
	    				?> <span class="label label-success">Validé</span><?php
	    			}
	    		?>
	    	</td>	    	
	    	<td><?php echo $value['res_note'] . '/' . $value['nb_question']; ?></td>
	    	<td><?php echo ($value['res_note']/$value['nb_question'])*20 . '/20'; ?></td>
	    </tr><?php
	 }?>
<?php
	$list_note = ob_get_clean();
?>