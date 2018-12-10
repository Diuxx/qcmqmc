<div class="row">
	<!-- message authentification -->
	<div class="col-md-6 col-md-offset-3 login" id="msg">
		<?= $message_authentification ?>
	</div>
	<div class="col-md-6 col-md-offset-3 login text-center" id="login">
		<!-- login form -->
		<h2>Serveur de QCM</h2>

		<a href="">
			<img src="logo.svg" alt="Serveur de qcm" height="124" width="200" style="margin-bottom: 30px;">
		</a>
		<form class="form-horizontal" method="post" action="?page=login">
			<div class="form-group">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input type="text" class="form-control" name="identifiant" placeholder="Nom d'utilisateur" required="required">
					</div>
				</div>
			</div>
			<div class="form-group text-center">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
						</span>
						<input type="password" class="form-control" name="soleil" placeholder="Mot de passe" required="required">
					</div>
				</div>							
			</div>
			<div class="form-group" style="margin-top: 35px;">
				<button type="submit" class="btn btn-info btn-sm"><span><i class="glyphicon glyphicon-log-in"></i>  Se connecter</span></button>
				<button type="button" class="btn btn-warning btn-sm"><span><i class="glyphicon glyphicon-thumbs-up"></i> Créer un compte</span></button>
			</div>
		</form>
	</div>
</div>