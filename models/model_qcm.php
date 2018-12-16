<?php
	$titre_qcm = 'No title';

	if(isset($_POST['qcm']) && isset($_POST['id']) && isset($_POST['titre'])) {

		$titre_qcm = htmlspecialchars(ucfirst($_POST['titre']));
		$id_qcm = $_POST['qcm']; // id du qcm
		$user_id = $_POST['id'];

		// cas ou c'est le prof qui visualise
		if($user_id != -1) {
			// --
			$sql = 'SELECT * FROM `qcm_resutat` WHERE `fk_res_utilisateur`= :user_id AND `fk_res_qcm` = :qcm_id';
			$prepared_request = $pdo->prepare($sql);

			$attr = array(
				'user_id' => $user_id,
				'qcm_id' => $id_qcm
			);		

			$prepared_request->execute($attr);

			// quand l'éleve a déja été noté on le jarte
			$estDejaNote = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
			if(count($estDejaNote) > 0) {
				header("Status: 301 Moved Permanently", false, 301);
				header('Location: ?page=accueil');
				exit();
			}
		}
		// var_dump($estDejaNote);

		$sql = 'SELECT * FROM `qcm_construction`, `qcm_question` WHERE `qcm_construction`.`fk_con_question` = `qcm_question`.`que_id` AND `fk_con_qcm` = :id';// 5bee1b07cbb58
		$prepared_request = $pdo->prepare($sql);
		$prepared_request->execute(['id' => $id_qcm]);

		$questions = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
		foreach ($questions as $key => $uneQuestion) {
			// parcours des questions du qcm
			$question_id = $uneQuestion['que_id'];// id de la question

			$sql = 'SELECT * FROM `qcm_reponse` WHERE `fk_question` = :id';
			$prepared_request = $pdo->prepare($sql);
			$prepared_request->execute(['id' => $question_id]);

			$lesResponses = $prepared_request->fetchAll(PDO::FETCH_ASSOC);
			//array_push($questions[$key], 'reponses', $lesResponses);

			$questions[$key]['reponses'] = $lesResponses;
			//var_dump( $lesResponses);
		}
		//var_dump($questions);
	} else {
		header('Location: ?page=home');
	}
?> 
<?php
	ob_start();
?>
<p><a name="qcm"></a></p>
<table>
	<tr>
		<td id="prem" class="titrebig" style="background-color: black;"><?php echo $titre_qcm; ?><a class="retour" href="?page=accueil">&lt;Retour</a></td>
	</tr>
</table>
<table id="quest">
    <tr>
		<td class="letexte">
			<p class="letexte">
				Veuillez répondre aux qcm en séléctionnant les reponses juste.<br>
				Attention il peut y avoir plusieurs bonnes réponses.<br><br>
				- 1 Bonne réponse rapporte 1 point<br>
				- 1 Mauvaise réponse rapport -0 points
				<br><br>
				BON COURAGE
			</p>
		</td>
    </tr> 
</table>           
<div id="questionnaire">
	<?php
		if(isset($questions))
		{	
			$i = 0;
			foreach ($questions as $key => $uneQuestion) {?>
				<div class="question" id=<?php echo '"q' . $i . '"'; ?>> 
				  	<p class="letexte"><?php echo $key .') '. htmlspecialchars($uneQuestion['que_libelle'], ENT_QUOTES); ?></p>
				  	<?php
				  	if(count($uneQuestion['reponses']) > 0) { // n'est pas un vrais ou faux
				  		foreach($uneQuestion['reponses'] as $key => $uneReponse) {
							?>
							<input type="checkbox" class="check" value="0" style="margin-bottom: 10px;"><?php echo ' ' . htmlspecialchars($uneReponse['rep_libelle']); ?><br>
							<?php
				  		}
				  	} else {?>
					  	<input type="radio" name=<?php echo '"choix' . $i . '"'; ?> class="true" value="1" style="margin-bottom: 10px;" unchecked>vrais<br>
					 	<input type="radio" name=<?php echo '"choix' . $i . '"'; ?> class="false" value="0" style="margin-bottom: 10px;">faux<br>
				  		<?php
				  	}?>
				</div>
			<?php
				$i++;
			}
		}
	?>
	<?php 
	if($user_id != -1) {
		?>
		<input class="bouton" onclick="verif();" value="Soumettre" name="B3" type="button"/>	
		<?php
	}
	?>
</div>
<?php
	$qcm_page = ob_get_clean();
?>
