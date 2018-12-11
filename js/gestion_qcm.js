
/**
 * Requete ajax recherche des qcm
 */
function aj_afficherQcm() {
	// --
	$.ajax({
		url: "ajax/qcm_get.php",
		async: true,
		success: function(result) {
			// --*{qcm_id: "1", qcm_libelle: "test DQL", qcm_active: "0", qcm_fdate: "2018-11-22", fk_qcm_utilisateur: "1"}
			var output = '';
			output += `<tr>
                        <td colspan="6" style="color: red;border-bottom: 1px black;text-align: center;">Liste des Qcm disponible</td>
                       </tr>`;

			for(let i=0; i< result.length; i++) {
				var unQcm = result[i];	
				console.log(unQcm);

				var uneDate = unQcm.qcm_fdate.split('-')
				var dateqcm = new Date(uneDate[0], uneDate[1] - 1, uneDate[2]); // la date commence a 0(janvier)
				var start = Date.now();

				var check = $('#checkboxdesact').is(':checked');

				// affichage des qcm désactivé
				if(unQcm.qcm_active == 0 && !check)
					continue;

				output += `		 				
					<tr class="${((start < dateqcm) ? "success":"danger")}">
                        <td>${unQcm.qcm_libelle}</td>
                        <td><input type="text" class="datepicker" value="${unQcm.qcm_fdate}" onchange="changeDate(this, '${unQcm.qcm_id}')" style="width:75px;"></td>
                        <td>
							<form action="?page=qcmqcm" method="post">
								<input type="hidden" name="modifier" value="${unQcm.qcm_id}">
								<button type="submit" class="btn btn-link" value="Modifier">Modifier</button>
							</form>
						</td>
						<td>
							<form action="?page=qcm" method="post" target="BLANK">
		        				<input class="hidden" type="text" name="titre" value="${unQcm.qcm_libelle}">
		        				<input class="hidden" type="text" name="qcm" value="${unQcm.qcm_id}">
		        				<input class="hidden" type="text" name="id" value="-1">
								<input type="submit" class="btn btn-info btn-xs" value="Visualiser"> 
							</post>
						</td>
                        <td><a href="#" onclick="supprimerQcm('${unQcm.qcm_id}')"><span class="glyphicon glyphicon-trash" style="color: red;"></span></a></td>
                        `;
                    if(unQcm.qcm_active == 0) {
                    	output += `<td><button type="submit" class="btn btn-success btn-xs" onclick="activationQcm('${unQcm.qcm_id}', 1);">activer</button></td>`;
                    } else {
                    	output += `<td><button type="submit" class="btn btn-danger btn-xs" onclick="activationQcm('${unQcm.qcm_id}', 0);">desactiver</button></td>`;
                    }
                    output += `</tr>`;
			}
			$("#list-qcm").html(output);
			$(function() { // methode moche mais ça marche
		    	$('.datepicker').datepicker({
		            dateFormat: 'yy-mm-dd',
		            showButtonPanel: true,
		            changeMonth: true,
		            changeYear: true,
		            defaultDate: new Date()
		        });
		    });
		},
		dataType: "json"
	});
	return this;	
}

$(document).ready(function() {

	aj_afficherQcm();

	$(function() {
    	$('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            defaultDate: new Date()
        });
    });

	$('#checkboxdesact').change(function() {
	    // this will contain a reference to the checkbox   
		aj_afficherQcm();
	});

	afficherMessage(2, "Vous pouvez modifer la date des QCM simplement. Cliquez sur la date et changez-la.");

});


function changeDate(elem, qid) {
	//alert($(elem).val());

	var ndate = $(elem).val();
	var iid = qid;

	$.ajax({
		url: "ajax/qcm_changeDate.php",
		async: true,
		data: { id: iid, date: ndate },
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
    		aj_afficherQcm();
		},
		dataType: "json"
	});
}

// supprimer un qcm de la base de données
function supprimerQcm(qid) {

	if (!confirm("Etes-vous sûr de vouloir supprimer ce questionnaire ?")) {
    	return false;
	}

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
						afficherMessage(1, result[err]);
						break;
					case '2':
						afficherMessage(4, result[err]);
						break;
				}
			}
    		aj_afficherQcm();
		},
		dataType: "json"
	});
	return false;
}

// Activation et désactivation d'un qcm
function activationQcm(qid, bool) {
	$.ajax({
		url: "ajax/qcm_activation.php",
		async: true,
		data: { id: qid, active:bool },
		type: "post",
		success: function(result) {
			// --
			console.log(result);
			/*for(var err in result)
			{
				switch(err) {
					case '1':
						afficherMessage(1, result[err]);
						break;
					case '2':
						afficherMessage(4, result[err]);
						break;
				}
			}*/
			aj_afficherQcm();
		},
		dataType: "json"
	});
	return false;
}
