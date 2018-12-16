
// Variable de configuration
var lesQuestion = []; // les questions chargé depuis l'api

// Les themes aussi sont chargé depuis l'api dédié
var lesTheme = [];

// Important, comptient le nombre de questions à afficher par pager. défaut = 10;
var nombreQuestionParPager = 10;

// Lors de la création d'une question le nombre de réponses possible est initalisé à 1. 
// Il augmente ensuite.
var nb_reponse = 1; // nombre de réponses possible


// demande confirmation à l'utilisateur lorsqu'il effectue une suppression.
function confirmDeleteQuestion(qid) {
    if (confirm("Etes-vous sûr de vouloir supprimer cette question ?")) {
        ajaxRemoveQuestion(qid);
    }
}

// Enlève une reponse possible à la question en cours de création
function enleverUneReponse() {
	if(nb_reponse == 1) return false;

	$("#repNb" + nb_reponse).remove();
	nb_reponse = nb_reponse - 1;
	return true;
}

// affichage de la page accueil des professeur.
$(document).ready(function() {

	// Affichage des question à la fin du chargement de la page web
	afficherQuestion();

	// affichage des différents theme existant
	ajaxGetTheme();

	// affichage simple et affichage de l'inteface pour créer une nouvelle question
	$("#newQuestion").on("click", function(e) {
		e.preventDefault();
		if($("#panel-ajout-question").css('display') != 'none') {
			// --
			$("#panel-ajout-question").css('display', 'none');
		} else {
			$("#panel-ajout-question").css('display', 'block');
		}
	});

	
	// ajouter la question à la base de donnée (click)
	$("#add-question").on("click", function(e) {
		e.preventDefault();
		// début des testes
		test = $("#inputQuestion").verifier("Veuillez renseigner une question.");
		// verif sur les reponses
		if(!$("#checkbox-vraisfaux").prop('checked'))
		{
			var i = 1;// counter de réponses
			do {
				test &= $("#text-reponse" + i).verifier("Veuillez renseigner un libelle de reponse à votre question.");
				i++; // on change de champs
			} while($("#text-reponse" + i).length > 0);

			// nombre de checkbox cochée
			var nbChecked = $("#add-reponses").find("input[type=checkbox]:checked").length;
			if(nbChecked == 0)
			{
				// on enlève la précedente feedback
				$("#add-reponses").children("small[class=text-muted]:last").remove();
				$("#add-reponses").append(
				`<small id="passwordHelpInline" class="text-muted">
				    **Toutes les réponses ne peuvent être fausses. Veuillez renseigner au moins une réponse vrais !
				</small>`);
				test &= (nbChecked != 0);	
			}
		}
		// verification des champs
		if(test) {
			// ajout des question a bdd
			ajouterQuestionBdd();
		}
	});

	// ajout d'une nouvelle reponse
	$("#new-reponse").on("click", function(e) {
	 	e.preventDefault();
	 	$("#add-reponses").children("small[class=text-muted]:last").remove();
	 	// on ajoute une reponse
	 	nb_reponse = nb_reponse + 1;

		// code html à inserer dans la page (ici une réponse).
	 	var output = '';
	  	output += `
    	<div class="form-group" id="repNb${nb_reponse}">
			<div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text">
                        <span><input type="checkbox" id="checkbox-reponse${nb_reponse}"> vrais</span>
                    </div>
                </div>
                <input type="text" id="text-reponse${nb_reponse}" class="form-control" placeholder="Reponse n°${nb_reponse}">
                <div class="input-group-addon">
                </div>                
            </div>
    	</div>`;

	  	// ajout
	  	$("#add-reponses").append(output);
	});

	// modifier une question
	$("#modifier-question").on("click", function(e) {
		// --
	    if(!confirm("Etes-vous sûr de vouloir modifier cette question ?")) {
	        return 1;
	    }
	    // récupération de l'id de la question.
	    var qid = $('#qid-modifier').val();
		$.ajax({
			url: "ajax/remove_question.php",
			async: true,
			data: { id: qid },
			type: "post",
			success: function(result) {
				afficherMessage(2, result[1]);
				ajouterQuestionBdd();
			},
			dataType: "json"
		});
	    //afficherMessage(2, "La question à été modifier avec succes ! (" + qid + ")");
	});


	// Changement d'état de la checkbox permetant de choisir le type de questions
	$("#checkbox-vraisfaux").change(function() {
		if($("#checkbox-vraisfaux").prop('checked'))
		{

			if(!confirm("Etes-vous sûr de vouloir passer à une réponse de type vrais faux ?\nVous allez perdre les réponses associer à une question de type multi réponses.")) {

				$("#checkbox-vraisfaux").prop('checked', false);

				return false;
			}

			console.log("affichage du vrais ou faux");
			var output = `
			<div class="radio">
			  <label><input type="radio" id="optradio1" name="optradio" checked>Vrais</label>
			</div>
			<div class="radio">
			  <label><input type="radio" id="optradio2" name="optradio">Faux</label>
			</div>`;
			// on cache le boutont new-reponse.
			$("#new-reponse").hide();
			$("#delete-last-reponse").hide();

			// affichage des box
			$("#add-reponses").html(output);
		} else {
			console.log("ré-affichage des reponses differentes");

			nb_reponse = 1; // on réinitialise le nombre de réponses
			output = `
	    	<div class="form-group">
				<div class="input-group">
	                <div class="input-group-addon">
	                    <div class="input-group-text">
	                        <span><input type="checkbox" id="checkbox-reponse${nb_reponse}"> vrais</span>
	                    </div>
	                </div>
	                <input type="text" id="text-reponse${nb_reponse}" class="form-control" placeholder="Reponse n°${nb_reponse}">
	            </div>
	    	</div>`;
		  	// on affiche le boutont new-reponse.
			$("#new-reponse").show();
			$("#delete-last-reponse").show();
		  	// écrase
		  	$("#add-reponses").html(output);
		}
	});
	afficherMessage(2, '<div style="text-align: center;">Bienvenue sur Cette interface web dédié à la création de Qcm</div>');
});

// requete ajax ajoutant un theme à la base de donnée
function ajaxAddTheme(qtheme) {
	// --
	$.ajax({
		url: "ajax/add_theme.php",
		async: true,
		data: { theme: qtheme },
		type: "post",
		success: function(result) {
			// --
			console.log(result);
			alert(result[1]);
		},
		dataType: "json"
	});
	return this;	
}

// Supprime la question dont l'id est entré en param.
function ajaxRemoveQuestion(qid) {
	$.ajax({
		url: "ajax/remove_question.php",
		async: true,
		data: { id: qid },
		type: "post",
		success: function(result) {
			// alert(result[1]);
			afficherMessage(2, result[1]);
			console.log(result);
			afficherQuestion($('#select-theme2').value); // refresh des questions
		},
		dataType: "json"
	});
	return this;
}


// commande ajax permetant de rechercher et de lister les question présentes dans la base de données.
// la variable unTheme permet de rechercher uniquement les questions ascocier au theme.
function afficherQuestion(unTheme = -1) {
	// --
	var data = null;

	// lorsqu'il existe un theme en param on créé les données relatives.
	if(unTheme != -1)
	{
		data = { theme : unTheme };
	}

	// corps de la requete Ajax
	$.ajax({
		url: "ajax/get_question.php",
		async: true,
		data: data,
		type: "post",
		success: function(result) {
			// --
			lesQuestion = result;

			// fonction de tri et d'affichage
			afficherLesQuestions(result, nombreQuestionParPager, 1);
	},
	dataType: "json"});
	return this;
}

// Lourd ! fonctions de gestion d'affichage de question
// La gestion des page est faite ici.
function afficherLesQuestions(result, nombre, pas) {
	// varibale qui va nous afficher un html.
	var output = ''; // doit être initialisé vide.

	// varieble permetant d'afficher les pager [1,2,3] en fonction du nombre de questions
	var pager_output = `<ul class="pagination">`;

	// nombre de radio box.
	var nbRadio = 0;
	console.log(result.length); // log debug

	// gestion des page de questions.
	if(result.length > nombre)
	{
		// calcule du nombre de page exacte à afficher
		var nombreDePage = result.length / nombre >> 0;

		// on arondi à l'entier supérieur quand il le faut.
		if(result.length % nombre != 0)
			nombreDePage = nombreDePage + 1;
		// debug
		console.log("nombre de page : " + nombreDePage);

		// Enregistrement du code html et affichage
		for(var i=1; i<=nombreDePage; i++)
		{
			// --
			if(i != pas) {
				pager_output += `<li><a onclick="afficherLesQuestions(lesQuestion, ${nombreQuestionParPager}, ${i})">${i}</a></li>`;
			} else {
				pager_output += `<li class="active"><a>${i}</a></li>`;
			}
		}
	}
	pager_output += `</ul>`;
	$("#question_pager").html(pager_output);
	// affichage des questions
	var position = (pas - 1) * nombre;
	var max = (result.length < (position + nombre)) ? result.length : position + nombre;
	console.log("nombre de question : " + max); // débug affichage

	// Boucle sur les questions.
	for(var key=position; key<max; key++)
	{
		//console.log(result[key]);
		output += 
		`<tr>
            <td><a data-toggle="collapse" href="#collapse${result[key].question.id}" aria-controls="collapseExample">${escapeHtml(result[key].question.libelle)}</a>
                <div class="collapse" id="collapse${result[key].question.id}">
                    <div class="card card-body">`;
	    // test de l'existance de reponse(vrais/faux)
	    if(typeof result[key].reponse != "undefined") 
	    {
	    	result[key].reponse.forEach(function(reponse) {
	    		// console.log(reponse);
	    		output += 
			    `<div class="form-check">
      				<input class="form-check-input" type="checkbox" value="" id=reponse${reponse.rep_id} disabled ${(reponse.rep_vrais == 1) ? `checked`:``}>
      				<label class="form-check-label" for=reponse${reponse.rep_id}>
      					${escapeHtml(reponse.rep_libelle)}
      				</label>
      			</div>`;
	    	});
	    } else { // il s'agit d'un vrais ou faut.
	    	nbRadio++;
	    	vrais = (result[key].question.vrais == 1);
			// console.log(vrais);
	    	output +=
	    	`<div class="radio">
					<label><input type="radio" name="optradio${nbRadio}" ${((vrais) ? `checked` : ``)} disabled> Vrais</label>
				</div>
				<div>
					<label><input type="radio" name="optradio${nbRadio}" ${((!vrais) ? `checked` : ``)} disabled> Faux</label>
				</div>`;
	    }

	    // fin de l'affichage
	    output += 
	    `	</div>
        </div>
            </td>
            <td align="center">
	    		<button type="button" class="btn btn-xs">${result[key].theme.libelle} <span class="badge">${result[key].auteur.nom}</span></button>
            </td>
            <td>
            	<form method="post">
            		<input type="hidden" name="modifier" value="${result[key].question.id}">
            		<button type="submit" class="btn btn-link" value>Modifier</button>
            	</form>
            </td>
            <td><a href="#"><span class="glyphicon glyphicon-trash" style="color: red;" onclick="confirmDeleteQuestion('${result[key].question.id}')"></span></a></td>
            </tr>`;
	}
	$("#list-projet").html(output);
}


// focntion ajax recherchant les themes présent par la bdd.
function ajaxGetTheme() {
	// --
	$.ajax({
		url: "ajax/get_theme.php",
		async: true,
		success: function(result) {
			// --
			lesTheme = result;

			// affichage des theme dans la page.
			afficherLesThemes(result);
		},
		dataType: "json"
	});
	return this;	
}

// Affiche les themes dans la page accueil prof (select)
function afficherLesThemes(themes) {
	// js to html
	var output = ''; 
	var output_theme2 = '<option value="-1">Tous les themes</option>'; // la valeur -1 conrespond à tous les themes
	for(var i in themes) // ---
	{
		console.log( themes[i]);
		output += `<option value="${themes[i].the_id}">${ucfirst(themes[i].the_libelle)}</option>`;
		output_theme2 += `<option value="${themes[i].the_id}">${ucfirst(themes[i].the_libelle)}</option>`;
	}
	//$(".select-theme").html(output);
	$(".select-theme2").html(output_theme2);
}


// Important ! ajouter les nouvelles questions à la base de données
function ajouterQuestionBdd() {
	// la question
	var question = $("#inputQuestion").val();
	var theme = $("#select-theme").val();
	var user_id = $("#id-user").val();

	// contient les données envoyé au serveur
	var data = null;

	var vraisfaux = 0;
	if($("#checkbox-vraisfaux").prop('checked'))
	{
		vraisfaux = ($("#optradio1").is(":checked")) ? 1:0;
		data = {
			form : {
				question : question,
				theme : theme,
				vraisfaux : vraisfaux,
				userid : user_id
			}};
	} else
	{
		var reponse = new Array(0); // tableaue de reponse à la question.
		var reponse_vrais = new Array(0); // tableau reponse à la question vrais ou pas.
		var i = 1;
		do {
			reponse.push($("#text-reponse" + i).val());
			reponse_vrais.push(($("#checkbox-reponse" + i).prop("checked")) ? 1:0);
			console.log(reponse[i-1] + " -> " + reponse_vrais[i-1]);
			i++;
		} while($("#text-reponse" + i).length > 0);

		data = {
			reponsevrais : JSON.stringify(reponse_vrais),
			reponse : JSON.stringify(reponse),
			form : {
				question : question,
				theme : theme,
				vraisfaux : vraisfaux,
				userid : user_id
			}};
	}
	console.log(data);

	// exeution de la requete ajax
	$.ajax({
		url: "ajax/add_question.php",
		type: "post",
		async: true,
		data: data,
		success: function(result) {
			// window.alert(result);
			console.log("ajout : " + result);
			afficherMessage(2, "ajout : " + result);
			afficherQuestion();
		},
		dataType: "json"
	});		
}