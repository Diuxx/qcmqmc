$(document).ready(function() {
	
	// affichage des themes
	aj_afficherTheme();

	// bouton de création des themes
	$("#btn-creation-theme").on("click", function(event) {
		event.preventDefault();
		if($("#input-creation-theme").verifier("Ajoutez un nom à votre theme")) {
			// --
			var theme = $("#input-creation-theme").val();
			ajaxAddTheme($("#input-creation-theme").val());
		}
	});
});

function aj_afficherTheme() {
	// --
	$.ajax({
		url: "ajax/get_theme.php",
		async: true,
		success: function(themes) {
			// --
			var output = '';

			output += `<tr>
                        <td colspan="2" style="color: red;border-bottom: 1px black;text-align: center;">Themes disponibles</td>
                       </tr>`;


			for(var i in themes) // ---
			{
				console.log( themes[i]);
				output += `<tr>
		                    <td>${ucfirst(themes[i].the_libelle)}</td>
		                    <td><button type="submit" class="btn btn-danger btn-xs" onclick="ajaxDeleteTheme(i=${themes[i].the_id});">supprimer <span class="badge badge-light">${themes[i].nb_question}</span></button></td>
		                   </tr>`;
			}
			$("#list-theme").html(output);

		},
		dataType: "json"
	});
	return this;	
}

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
			for(var err in result)
			{
				switch(err) {
					case '1':
						afficherMessage(4, result[err]);
						break;
					case '2':
						afficherMessage(1, result[err]);
						aj_afficherTheme(); // on refresh l'affichage des themes
						break;
				}
			}
		},
		dataType: "json"
	});
	return this;	
}

// suppression du theme si il n'a pas de questions ascossié.
function ajaxDeleteTheme(qid) {

	if( !confirm("Etes vous sûr de vouloir supprimer le theme ?"))
		return false;

	$.ajax({
		url: "ajax/theme_delete.php",
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
						afficherMessage(1, result[err]);
						aj_afficherTheme(); // on refresh l'affichage des themes
						break;
					case '2':
						afficherMessage(4, result[err]);
						break;
				}
			}
		},
		dataType: "json"
	});
}
