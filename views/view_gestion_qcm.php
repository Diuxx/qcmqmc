<div id="corp-page" class="container-fluid" style="padding-top: 10px;">
	<div class="row">
		<?= $menu ?>

	    <!-- message authentification -->
	    <div class="col-md-6 col-md-offset-2" id="messagemessage">
	        <!-- code code code -->
	    </div>

		<div class="col-sm-4 col-md-offset-3" id="qcm-qcm">
			<div>
				<div class="checkbox">
				  <label><input type="checkbox" id="checkboxdesact" value="">  Afficher les questionnaires désactivés</label>
				</div>
			</div>

			<!-- list des qcm -->
            <div class="table-responsive">          
                <table class="table table-borderless table-sm">
                    <tbody id="list-qcm">
                    	<!-- liste des qcm (chargement) 
                    	si js d'ésactivé on gère une affichage en php -->    	
                    </tbody>
                </table>                      
        	</div>
		</div>

		<script src="js/gestion_qcm.js"></script>
	</div>
</div>