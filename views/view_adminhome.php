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
								<div class="col-lg-5 col-md-offset-5" id="panel-ajout-question" style="display: none; border: 1px solid #e0e0e0;">
				                    <form class="form-horizontal" id="form-form" style="margin: 5px;">

				                    	<div class="row">
				                    		<div class="col-sm-12">
					                            <div class="form-group">
					                                <input type="hidden" name="" id="id-user" value=<?php echo '"' . $utilisateur->getId() . '"'; ?>>
					                                <label for="inputQuestion">Ajouter une question :</label>
					                                <input type="text" class="form-control input-sm" name="inputQuestion" id="inputQuestion" placeholder="La question">
					                            </div>
					                        </div>
				                        </div>
			                            <div class="form-group col-sm-4">
			                            	<label for="select-theme"><i>Theme :</i></label>
		                                    <select class="form-control input-sm select-theme" name="select-theme" id="select-theme">
		                                    	<!-- liste des theme -->
		                                    </select>
			                            </div>

				                        <div class="row">
				                            <div class="col-sm-12" style="margin-bottom: 10px;">
				                                <div class="checkbox">
				                                    <label><input type="checkbox" name="checkbox-vraisfaux" id="checkbox-vraisfaux"> Question de type vrais ou faux</label>
				                                </div>
				                            </div>           
				                        </div>
				                        <div class="row">
					                        <div class="col-md-12" id="add-reponses">
					                        	
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
					                        </div>                        
				                        </div>
				                        <div class="row text-center" id="button-form" style="margin-top: 10px;">
				                        	<div class="btn-group">
												<button type="button" class="btn btn-default" id="new-reponse"><span class="glyphicon glyphicon-plus"></span></button>
												<button type="button" class="btn btn-primary" name="add-question" id="add-question">Créer question</button>
												<button type="button" class="btn btn-default" onclick="enleverUneReponse()" id="delete-last-reponse"><span class="glyphicon glyphicon-minus"></span></button>
											</div>
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
	</div>
</div>