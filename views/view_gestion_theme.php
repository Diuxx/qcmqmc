<div id="corp-page" class="container-fluid" style="padding-top: 10px;">
	<div class="row">
		<?= $menu ?>

	    <!-- message authentification -->
	    <div class="col-md-6 col-md-offset-2" id="messagemessage">
	        <!-- code code code -->
	    </div>

		<div class="col-sm-4 col-md-offset-3" id="qcm-qcm">
			<!-- list des qcm -->
			<div>
				<form class="form-inline" action="#" methode="post" style="padding-bottom: 5px;">
					<input type="text" class="form-control" name="nouveautheme" placeholder="Nouveau theme" id="input-creation-theme" value="">
					<button type="submit" class="btn btn-warning" id="btn-creation-theme">Créer</button>
				</form>
			</div>
		    <div class="table-responsive">          
		        <table class="table table-borderless table-sm">
		            <tbody id="list-theme">
		            	<!-- list exaustive des themes -->
						<tr>
		                    <td colspan="2" style="color: red;border-bottom: 1px black;text-align: center;">Themes disponibles</td>
		                </tr>   	
		            </tbody>
		        </table>                      
			</div>
		</div>
		<script src="js/gestion_theme.js"></script>
	</div>
</div>