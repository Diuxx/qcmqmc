<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">	
	<head>
		<TITLE><?php echo 'QCM : ' . $titre_qcm; ?></TITLE>
		<link rel="stylesheet" type="text/css" href="xls.css" />
		<style type="text/css">
			span {
				font-weight:bold;
				font-size:21px;
			}
			#resul { // Pour les questionnaires Oui/Non
				margin-top:25px;
				padding-top:5px;
				float:right;
				border:1px dotted gray;
				width:350px;
				height:30px;
				background-color:#90EE90;
				text-align:center;
				font-family:calibri;
				font-size:18px;
			}	

			.bouton {
				float left;
				margin-top:30px;
				margin-right:30px;

			}
			#questionnaire {
				width:800px;
				margin-left:auto;
				margin-right:auto;
				margin-top:20px;
			}
			#quest td{
				border:1px solid gray;
				padding:7px;
				cursor:pointer;
				vertical-align:middle;

			}
			.rep {
				width:40px;
				text-align:center;
			}
						
			form {
				padding-bottom:7px;
				margin-top:7px;
				border-bottom:1px dotted gray;
				cursor:pointer;
			}

			.question {
				padding-bottom:7px;
				margin-top:7px;
				border-bottom: 1px dotted gray;
				cursor:pointer;				
			}		
		</style>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	</head>
	<body>
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
						Vieuillez répondre aux qcm en séléctionnant les reponses juste. Attention il peut y avoir plusieurs bonnes réponses.<br>
						- 1 Bonne réponse rapporte 1 point<br>
						- 1 Mauvaise réponse rapport -0 points
						<br>
						bon courage
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
						  	<p class="letexte"><?php echo $key .') '. $uneQuestion['que_libelle']; ?></p>
						  	<?php
						  	if(count($uneQuestion['reponses']) > 0) { // n'est pas un vrais ou faux
						  		foreach($uneQuestion['reponses'] as $key => $uneReponse) {
									?>
									<input type="checkbox" class="check" value="0" style="margin-bottom: 10px;"><?php echo ' ' . $uneReponse['rep_libelle']; ?><br>
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
	   		<input class="bouton" onclick="verif();" value="Soumettre" name="B3" type="button"/>
		</div>
		<script type="text/javascript">
			function verif() {
				var points = 0;
				var qcm = <?php echo (isset($questions) ? json_encode($questions):"" ); ?>;
				var qcm_id = <?php echo (isset($id_qcm) ? json_encode($id_qcm):"" ); ?>;
				var user_id = <?php echo (isset($user_id) ? json_encode($user_id):"" ); ?>;

				for(var i=0; i<qcm.length; i++) {
					// --
					//console.log($("#q" + i).find(".ckeck"));
					if(qcm[i].reponses.length > 0) {
						var boolPoints = true;
						$("#q" + i + " > .check").each(function(rep) {
							var isTrueSet = (String(qcm[i].reponses[rep].rep_vrais) === "1");
							boolPoints = (isTrueSet == $(this).is(':checked')) && boolPoints;
						});
					} else { // vrais faux..
						// console.log("reponse vrais faux : " + qcm[i].que_reponse);
						if(qcm[i].que_reponse == 1) {

							boolPoints = $("#q" + i + " .true").is(":checked");
						} else {
							boolPoints = $("#q" + i + " .false").is(":checked");
						} // console.log(boolPoints);
					}
					if(boolPoints) {
						// si boolPoint est vrais alors on ajout 1 points au candidat
						points += 1;
					}
				}	
				console.log("nombre de points : " + points + "/" + qcm.length);

				enregistrerNote(user_id, qcm_id, points);
				return points;	
			}

			function enregistrerNote(quser_id, qqcm_id, qnote) {

				if(!confirm("Etes vous sûr de la validation du qcm ?")) 
					return false;

				$.ajax({
					url: "ajax/resultat_add.php",
					async: true,
					data: { user_id: quser_id, qcm_id: qqcm_id, note: qnote },
					type: "post",
					success: function(result) {
						console.log(result);
						alert(result[2]);
						document.location.href = "?page=accueil";
					},
					dataType: "json"
				});
				return true;
			}
		</script>

	</body>
</html>