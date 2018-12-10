

// Première lettre (string) en majuscule
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


var entityMap = {
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
  '/': '&#x2F;',
  '`': '&#x60;',
  '=': '&#x3D;'
};

// filtre une chaine - caractères spec
function escapeHtml(string) {
  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
    return entityMap[s];
  });
}

/**
 * Affiche un message sur dans la div d'id (id)
 */
function afficherMessage(type, text)
{
	var output = ''; // affichage

	// class de l'alert(bootstrap)
	var classs = '';

	//$("#messagemessage").empty();
	switch(type) {
		case 1:
			classs = "alert alert-success";
			break;
		case 2:
			classs = "alert alert-info";
			break;
		case 3:
			classs = "alert alert-warning";
			break;
		case 4:
			classs = "alert alert-danger";
			break;
		default:
			classs = "alert alert-info";
	}
	output = `
        <div class="${classs}">
            ${text}
        </div>
	`;
	$("#messagemessage").append(output).fadeIn().delay(4000).fadeOut(500, function() {
		$(this).empty().show();
	});
}

/**
 * Verificatio3n d'un du champs utilisant cette fonction.
 */
$.fn.verifier = function(message)
{
	console.log(this.prop("checked")); // --
	this.parent().parent().children("div[id=alert]:last").remove();
	//if($("#checkbox-reponse" + i).prop("checked"))

	if(this.val() == "") {
		//this.removeClass("is-valid is-invalid").addClass("is-invalid");
		//this.remove(".invalid-feedback");// on enlève la précedente feedback
		this.parent().parent().removeClass("has-error has-feedback").addClass("has-error has-feedback");

		this.parent().parent().children("div[id=alert]:last").remove();

		this.parent().parent().append(
			`<div class="alertbox" id="alert">
				<p>${message}</p>
			 </div>`);
		return false;
	}
	this.parent().parent().removeClass("has-error has-feedback").addClass("is-valid");
	return true;
}


function indisponible(id) {
	alert("cette fonction est indisponible pour la version actuel de l'application. (" + id);
}


