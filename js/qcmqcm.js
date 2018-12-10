
/**
 * requete ajax pour l'affichage des Questions
 */
function aj_afficherQuestion(unTheme = -1) {
	// --
	var data = null;
	if(unTheme != -1) {
		data = { theme : unTheme };
	}

	$.ajax({
		url: "ajax/get_question.php",
		async: true,
		data: data,
		type: "post",
		success: function(result) {
			// --
			var output = '';
			result.forEach(function(uneQuestion) {
				output += `
				<tr>
					<td>
						<button type="button" class="btn btn-xs">${uneQuestion.theme.libelle}</button>
					</td>
                    <td>${uneQuestion.question.libelle}</td>
                    <td class="hidden">${uneQuestion.question.id}</td>                       
                    <td><button type="submit" class="btn btn-success btn-xs" onclick="ajouterUneQuestion(this);">ajouter</button></td>
                </tr> `		
			});
			$("#list-question").html(output);
	},
	dataType: "json"});
	return this;
}


// demande confirmation à l'utilisateur lorsqu'il veut modifier une questionnaire
function confirmDeleteQuestion(qid, libelle) {
    return confirm("Etes-vous sûr de vouloir modifier ce questionnaire ?");
}


function getLabel() {
	var n = Math.floor(Math.random() * 6);
	var label = '';
	switch(n) {
		case 0:
			label = 'label label-default';
			break;
		case 1:
			label = 'label label-primary';
			break;
		case 2:
			label = 'label label-success';
			break;
		case 3:
			label = 'label label-info';
			break;
		case 4:
			label = 'label label-warning';	
			break;			
		case 5:
			label = 'label label-danger';	
			break;
	}
	return label;
}


function ajouterUneQuestion(unTd) {
	var output = '';
	output += `<tr class="unequestion">
                <td>${$(unTd).parent().parent().find("td:eq(1)").text()}</td>
                <td class="hidden">${$(unTd).parent().parent().find("td:eq(2)").text()}</td>
                <td><button type="submit" class="btn btn-danger btn-xs" onclick="supprimerUneQuestion(this);">supprimer</button></td>
            </tr>`	

	$("#list-construction").append(output);
}

/**
 *	Supprime une question lors de la création
 */
function supprimerUneQuestion(unTd) {
	$(unTd).parent().parent().remove();
}

$(document).ready(function() {

	//aj_afficherQcm();
	aj_afficherQuestion();
	aj_getTheme();// affichage des themes dans le select

	$(function() {
    	$('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            defaultDate: new Date()
        });
    });

	// création du qcm quand on click sur le bouton de création
	$("#create-qcm").on("click", function(e) {
		e.preventDefault();

		// appel de la fonction de création du qcm
		createQcm();
	});

	// modification d'un qcm c'est très simple
	$("#modifier-qcm").on("click", function(e) {
		e.preventDefault();

		if (!confirm("Etes-vous sûr de vouloir modifier ce questionnaire ?")) {
        	return false;
    	}

    	var qid = $("#qcm_id").val();
    	// alert(id);

    	// méthode simple. suppression et création d'un autre qcm
    	//aj_supprimerQCM(id);//history.go(0);
		$.ajax({
			url: "ajax/qcm_remove.php",
			async: true,
			data: { id: qid },
			type: "post",
			success: function(result) {
				// --
				console.log(result);
				for(var err in result)
				{
					switch(err) {
						case '1':
							afficherMessage(4, result[err]);
							break;
						case '2':
							afficherMessage(1, result[err]);
							break;
					}
				}
				// création
	    		createQcm(2); // --
			},
			dataType: "json"
		});
    	// clean clean !
    	/*$("#titre-qcm").val("");
    	$(".unequestion").remove();
		$("#create-qcm").removeClass("hidden");*/

    	return true;
	});

})

// création du qcmqcm v2 hors du onclick pour réutilisation
function createQcm(ref = 1) {
	// test le nom du qcm
	if(!$("#titre-qcm").verifier("donnez un titre à votre qcm.")) {
		return false;
	}

	var tableau_de_question = [];
	var titre_qcm = $("#titre-qcm").val();
	var date_qcm = $("#date-qcm").val();
	var active_qcm = (($("#active-qcm").prop("checked") == true) ? 1:0);

	$('.unequestion').each(function(index, obj)
	{	
		// console.log($(obj).children('td:eq(1)').html()); // debug
		var question_id = $(obj).children('td:eq(1)').html();
		tableau_de_question.push(question_id);
	});

	console.log(titre_qcm);
	console.log(date_qcm);
	console.log(tableau_de_question);
	console.log(active_qcm);

	// contient les données envoyé au serveur
	var data = null;
	data = {
		titre : titre_qcm,
		question : JSON.stringify(tableau_de_question),
		auteur : 1,
		date : date_qcm,
		active : active_qcm
	};

	$.ajax({
		url: "ajax/qcm_add.php",
		type: "get",
		async: true,
		data: data,
		success: function(result) {
			//window.alert(result);
			console.log(result);

			for(var err in result)
			{
				switch(err) {
					case '1':
						afficherMessage(4, result[err]);
						if(ref == 2) 
							alert(result[err]);
						break;
					case '2':
						afficherMessage(1, result[err]);
						if(ref == 2) 
							alert(result[err]);
						break;
				}
			}
			if(ref == 2)
				window.location.href = window.location.href;
		},
		dataType: "json"
	});	
	// ajax			
}

// blablabla
function aj_supprimerQCM(qid) {
	// --
	$.ajax({
		url: "ajax/qcm_remove.php",
		async: true,
		data: { id: qid },
		type: "post",
		success: function(result) {
			// --
			console.log(result);
			for(var err in result)
			{
				switch(err) {
					case '1':
						afficherMessage(4, result[err]);
						break;
					case '2':
						afficherMessage(1, result[err]);
						break;
				}
			}
			// création
    		createQcm(); // --
		},
		dataType: "json"
	});
	return this;
}

// focntion ajax recherchant les themes présent par la bdd.
function aj_getTheme() {
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
	var output_theme2 = '<option value="-1">Tous les themes</option>'; // la valeur -1 conrespond à tous les themes
	for(var i in themes) // ---
	{
		console.log( themes[i]);
		output_theme2 += `<option value="${themes[i].the_id}">${ucfirst(themes[i].the_libelle)}</option>`;
	}
	$(".select-theme2").html(output_theme2);
}