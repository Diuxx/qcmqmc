<div id="corp-page" class="container-fluid" style="padding-top: 10px;">
	<div class="row">
		<?= $menu ?>

	    <!-- message authentification -->
	    <div class="col-md-6 col-md-offset-2" id="messagemessage">
	        <!-- code code code -->
	    </div>

		<div class="col-lg-8 col-lg-offset-1">
		    <div class="container-fluid">
		        <div class="row">
		        	<!-- Main content -->
		        	<div class="col-lg-12" id="panel-list-question">
		                <!-- recherche par themes -->
		                <div class="row">
		                    <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;">
		                        <div class="form-group">
		                            <div class="col-sm-4 col-sm-offset-4">
		                                <div class="input-group">
		                                    <select class="form-control select-theme2" onchange="afficherQuestion(this.value)" id="select-theme2">
		                                    	<option value="-1">Tous les themes</option>
		                                    	<!-- ajout des themes js -->
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <button type="button" class="btn btn-info" id="newQuestion">Nouvelle Question</button>
		                        <!-- créer une nouvelle question -->
		                        <?php if(isset($qid)) {?>
									<div class="col-lg-7 col-md-offset-5" id="panel-ajout-question" style="border: 1px solid #e0e0e0;">
		                        <?php } else { ?>
									<div class="col-lg-7 col-md-offset-5" id="panel-ajout-question" style="display: none; border: 1px solid #e0e0e0;">
		                        <?php } ?>
				                    <form class="form-horizontal" id="form-form" style="margin: 5px;">

				                    	<div class="row">
				                    		<div class="col-sm-12">
					                            <div class="form-group">
					                                <input type="hidden" name="" id="id-user" value=<?php echo '"' . $utilisateur->getId() . '"'; ?>>
					                                <?php 
					                                	if(isset($qid)) {
					                                		?> 
					                                		<input type="hidden" name="qid" id="qid-modifier" value=<?php echo '"' . $qid . '"'; ?>>
					                                		<?php
					                                	}
					                                ?>
					                                <label for="inputQuestion">Ajouter une question :</label>
													<input type="text" class="form-control input-sm" name="inputQuestion" id="inputQuestion" placeholder="La question" 
													value=<?php echo '"' . ((isset($qid)) ? $question['question']['libelle']:'' ) . '"'; ?>>
					                            </div>
					                        </div>
				                        </div>
			                            <div class="form-group col-sm-4">
			                            	<label for="select-theme"><i>Theme :</i></label>
		                                    <!--
		                                    <select class="form-control input-sm select-theme-noajax" name="select-theme" id="select-theme-noajax">
		                                    -->
		                                    <select class="form-control input-sm select-theme" name="select-theme" id="select-theme">
		                                    	<!-- liste des theme -->
		                                    	<?php
													if(isset($qid)) {
														$the_id = $question['theme']['id'];
													}
		                                    		$sql = 'SELECT * FROM `qcm_theme` WHERE 1';
		                                    		$prepared_request = $pdo->prepare($sql);
													$prepared_request->execute();
													$result = $prepared_request->fetchAll(PDO::FETCH_ASSOC);

													$pos = 0;
													foreach ($result as $key => $theme) {
														
														if($pos == 0 && !isset($the_id)) { // on prend le 1er theme et on le met par défaut?
															$the_id = $theme['the_id'];
														}

														if( $the_id == $theme['the_id']) {
														?>
														<option value=<?php echo '"' . $theme['the_id'] . '"'; ?> selected="selected"><?php echo ucfirst($theme['the_libelle']); ?></option>
														<?php
														} else {
														?>
														<option value=<?php echo '"' . $theme['the_id'] . '"'; ?>><?php echo ucfirst($theme['the_libelle']); ?></option>
														<?php
														}
													}
		                                    	?>
		                                    </select>
			                            </div>

				                        <div class="row">
				                            <div class="col-sm-12" style="margin-bottom: 10px;">
				                                <div class="checkbox">
												<?php
												if(isset($qid)) {
													?><label><input type="checkbox" name="checkbox-vraisfaux" id="checkbox-vraisfaux"  <?php echo (!isset($question['reponse'])) ? 'checked':''; ?>> Question de type vrais ou faux</label><?php
												} else {
													?><label><input type="checkbox" name="checkbox-vraisfaux" id="checkbox-vraisfaux"> Question de type vrais ou faux</label><?php
												}
												?>
				                                </div>
				                            </div>
				                        </div>
				                        <div class="row">
					                        <div class="col-md-12" id="add-reponses">
					                        	
											<?php
											if(isset($qid)) {
												
												if(isset($question['reponse'])) { // n'est pas un vrais faux !
													$nbReponse = 1;
													foreach ($question['reponse'] as $key => $reponse) {
														# code...
														?>
														<div class="form-group" id=<?php echo '"repNb' . $nbReponse . '"'; ?>>
															<div class="input-group">
													            <div class="input-group-addon">
													                <div class="input-group-text">
													                	<?php
													                	if($reponse['rep_vrais'] == 1) {
													                		?>
																			<span><input type="checkbox" id=<?php echo '"checkbox-reponse' . $nbReponse . '"'; ?> checked> vrais</span>
													                		<?php
													                	} else {
													                		?>
													                		<span><input type="checkbox" id=<?php echo '"checkbox-reponse' . $nbReponse . '"'; ?>> vrais</span>
													                		<?php
													                	}?>
													                </div>
													            </div>
													            <input type="text" id=<?php echo '"text-reponse' . $nbReponse . '"'; ?> class="form-control" placeholder=<?php echo '"Reponse n°' . $nbReponse . '"'; ?> value=<?php echo '"' . $reponse['rep_libelle'] . '"'; ?>>
													            <div class="input-group-addon">
													            </div>    
													        </div>
														</div>
														<?php
														$nbReponse += 1;
													}
												} else { // vrais / faux
													?>
													<div class="radio">
													  	<label><input type="radio" id="optradio1" name="optradio" <?php echo ($question['question']['vrais'] == '1') ? 'checked':''; ?>>Vrais</label>
													</div>
													<div class="radio">
													  	<label><input type="radio" id="optradio2" name="optradio" <?php echo ($question['question']['vrais'] == '0') ? 'checked':''; ?>>Faux</label>
													</div>
													<?php
												}
											} else {
												?>
												<div class="form-group">
													<div class="input-group">
											            <div class="input-group-addon">
											                <div class="input-group-text">
											                    <span><input type="checkbox" name="checkbox-reponse" id="checkbox-reponse1"> vrais</span>
											                </div>
											            </div>
											            <input type="text" name="text-reponse" id="text-reponse1" class="form-control" placeholder="Question n°1">
											        </div>
												</div>
												<?php
											}
					                        ?>
					                        </div>                        
				                        </div>
				                        <div class="row text-center" id="button-form" style="margin-top: 10px;">
				                        	<div class="btn-group">
												<button type="button" class="btn btn-default" id="new-reponse"><span class="glyphicon glyphicon-plus"></span></button>
												<?php
													if(isset($qid)) {
													?>
														<button type="button" class="btn btn-warning" name="modifier-question" id="modifier-question">Modifier</button>
													<?php												
													} else {
														?>
														<button type="button" class="btn btn-primary" name="add-question" id="add-question">Créer question</button>
														<?php
													}
												?>
												<button type="button" class="btn btn-default" onclick="enleverUneReponse()" id="delete-last-reponse"><span class="glyphicon glyphicon-minus"></span></button>
											</div>

												<?php
													if(isset($qid)) {
													?>	
														<form action=""# method="post">
															<button type="submit" class="btn btn-danger" name="modifier-question" id="modifier-question">annuler</button>
														</form>
													<?php
													}											
												?>
				                        </div>
				                    </form>
				                </div>   
		                    </div>
		                </div>                                
		                <div class="table-responsive">          
		                    <table class="table table-borderless table-sm">
		                        <tbody id="list-projet">
		                        	<!-- liste des question (chargement) -->
		                        </tbody>
		                    </table>                      
		            	</div>
		            	<div class="row">
		                    <div class="col-md-12 text-center" id="question_pager">
		                        <script type="text/javascript">
		                            // à modifier..
		                            $(document).ready(function() {
		                                $(".pagination li").click(function() {
		                                    $('.pagination li').removeClass('active');
		                                    $(this).addClass('active');                                                 
		                                });
		                            });
		                        </script>
		                    </div>
		                </div> 
		            </div>
		        </div>
		    </div>
		</div>
		<script src="js/prof_question.js"></script>
		<?php
			if(isset($qid)) {
				?>
				<script type="text/javascript">
					var nb_reponse = <?php echo count($question['reponse']); ?>
				</script>
				<?php
			}
		?>
	</div>
</div>