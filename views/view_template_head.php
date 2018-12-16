<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Serveur de QCM</title>
		<meta name="description" content="Serveur permettant à des élèves de participer aux QCM mis à disposition par des enseignant.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- style sheet -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="w3.css">
        <link rel="stylesheet" href="bootstrap-3.3.7\dist\css\bootstrap.min.css">

		<!-- jquery -->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/qcmjs.js"></script>
        <script src="bootstrap-3.3.7\dist\js\bootstrap.min.js"></script>

        <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAA////AAAA/wAFBQUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABEREREAAAABERERERAAAAERARAREAAAABEBEBEAAAEiAAAAACIjARIiIiIiESABEiERIiEREAEiERERIREQAiIREREiESACIhERESIiIAASIRESIREAABEiIiIREQAAARIiIREQAAAAAiIhEAAAAAAAAAAAAADwDwAA4AcAAMADAADAAwAAgAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIABAACAAQAAwAMAAOAHAAD4HwAA" rel="icon" type="image/x-icon" />
	</head>
	<body>
        <?php
            // si t'utilisateur est enregistré..
            if(isset($utilisateur)) {
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <button class="navbar-toggler" type="button" id="menu-button">&#9776;</button>
                    Serveur de QCM</a>

                <!-- navbar -->
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo ucfirst($utilisateur->getPrenom()) . ' ' . ucfirst($utilisateur->getNom()); ?>  
                                <span class="glyphicon glyphicon-user"></span></span><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="post">
                                        <button type="submit" name="deco" class="btn btn-link"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
            } // isset utilisateur..
        ?>