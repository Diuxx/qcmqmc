<div id="corp-page" class="container-fluid" style="padding-top: 10px;">
	<div class="row">
		<?= $menu ?>

	    <!-- message authentification -->
	    <div class="col-md-6 col-md-offset-2" id="messagemessage">
	        <!-- code code code -->
	    </div>

		<div class="col-sm-6 col-md-offset-2" id="qcm-qcm">

			<!-- list des qcm -->
            <div class="table-responsive" style="max-height: 800px;overflow: auto;">          
                <table class="table table-borderless table-sm">
                    <tbody id="list-notes">
                    	<?= $notes ?>
                    </tbody>
                </table>                      
        	</div>
		</div>

		<script src="js/note_engeignant.js"></script>
	</div>
</div>
 