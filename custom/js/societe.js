
$(document).ready(function() {
	// active top navbar categories

$('#navUser').addClass('active');

	var divRequest = $(".div-request").text();
		if(divRequest == 'societe')  {
			$('#topNavSociete').addClass('active');	
	// on click on submit categories form modal
	$('#addSocieteModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#getSocieteInfomationForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#getSocieteInfomationForm").unbind('submit').bind('submit', function() {

			var nom_societe 		= $("#nom_societe").val();
			var siegle_societe 		= $("#siegle_societe").val();
			var tele_societe 		= $("#tele_societe").val();
			var pays 				= $("#pays").val();
			var province 			= $("#province").val();
			var commune_societe 	= $("#commune_societe").val();
			var tele_societeSecond 	= $("#tele_societeSecond").val();
			var quartier 			= $("#quartier").val();
			var avenue 				= $("#avenue").val();
			var numero 				= $("#numero").val();
			var tele_societe2 		= $("#tele_societe2").val();
			var bp 					= $("#bp").val();
			var email_societe 		= $("#email_societe").val();
			var assujetti_tva 		= $("#assujetti_tva").val();
			var NIF_societe 		= $("#NIF_societe").val();
			var Registre_commerce 	= $("#Registre_commerce").val();
			var centre_fiscal 		= $("#centre_fiscal").val();
			var forme_juridique 	= $("#forme_juridique").val();
			var secteur_activite 	= $("#secteur_activite").val();
			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

			if(nom_societe == "") {
				$("#nom_societe").after('<p class="text-danger">Ce champ  est obligatoire</p>');
				$('#nom_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#nom_societe").find('.text-danger').remove();
				// success out for form 
				$("#nom_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(siegle_societe == "") {
				$("#siegle_societe").after('<p class="text-danger">Siègle est obligatoire</p>');
				$('#siegle_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#siegle_societe").find('.text-danger').remove();
				// success out for form 
				$("#siegle_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(tele_societe == "" || tele_societe.match(phoneno)) {
				$("#tele_societe").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#tele_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_societe").find('.text-danger').remove();
				// success out for form 
				$("#tele_societe").closest('.form-group').addClass('has-success');	  	
			}

			if(pays == "") {
				$("#pays").after('<p class="text-danger">Pays est obligatoire</p>');
				$('#pays').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#pays").find('.text-danger').remove();
				// success pays for form 
				$("#pays").closest('.form-group').addClass('has-success');	  	
			}
			if(province == "") {
				$("#province").after('<p class="text-danger">Province est obligatoire</p>');
				$('#province').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#province").find('.text-danger').remove();
				// success out for form 
				$("#province").closest('.form-group').addClass('has-success');	  	
			}
			if(commune_societe == "") {
				$("#commune_societe").after('<p class="text-danger">Commune est obligatoire</p>');
				$('#commune_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#commune_societe").find('.text-danger').remove();
				// success out for form 
				$("#commune_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(quartier == "") {
				$("#quartier").after('<p class="text-danger">Quartier est obligatoire</p>');
				$('#quartier').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quartier").find('.text-danger').remove();
				// success out for form 
				$("#quartier").closest('.form-group').addClass('has-success');	  	
			}
			if(avenue == "") {
				$("#avenue").after('<p class="text-danger">Avenue est obligatoire</p>');
				$('#avenue').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#avenue").find('.text-danger').remove();
				// success out for form 
				$("#avenue").closest('.form-group').addClass('has-success');	  	
			}
			if(numero == "") {
				$("#numero").after('<p class="text-danger">Numéro est obligatoire</p>');
				$('#numero').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#numero").find('.text-danger').remove();
				// success out for form 
				$("#numero").closest('.form-group').addClass('has-success');	  	
			}

			if(email_societe == "") {
				$("#email_societe").after('<p class="text-danger">E-mail est obligatoire</p>');
				$('#email_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#email_societe").find('.text-danger').remove();
				// success out for form 
				$("#email_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(assujetti_tva == "") {
				$("#assujetti_tva").after('<p class="text-danger">TVA est obligatoire</p>');
				$('#assujetti_tva').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#assujetti_tva").find('.text-danger').remove();
				// success out for form 
				$("#assujetti_tva").closest('.form-group').addClass('has-success');	  	
			}
			if(NIF_societe == "") {
				$("#NIF_societe").after('<p class="text-danger">NIF est obligatoire</p>');
				$('#NIF_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#NIF_societe").find('.text-danger').remove();
				// success out for form 
				$("#NIF_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(Registre_commerce == "") {
				$("#Registre_commerce").after('<p class="text-danger">RC est obligatoire</p>');
				$('#Registre_commerce').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#Registre_commerce").find('.text-danger').remove();
				// success out for form 
				$("#Registre_commerce").closest('.form-group').addClass('has-success');	  	
			}
			if(centre_fiscal == "") {
				$("#centre_fiscal").after('<p class="text-danger">Centre Fiscal est obligatoire</p>');
				$('#centre_fiscal').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#centre_fiscal").find('.text-danger').remove();
				// success out for form 
				$("#centre_fiscal").closest('.form-group').addClass('has-success');	  	
			}
			if(forme_juridique == "") {
				$("#forme_juridique").after('<p class="text-danger">Forme Juridique est obligatoire</p>');
				$('#forme_juridique').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#forme_juridique").find('.text-danger').remove();
				// success out for form 
				$("#forme_juridique").closest('.form-group').addClass('has-success');	  	
			}
			if(secteur_activite == "") {
				$("#secteur_activite").after('<p class="text-danger">Secteur d\'Activite est obligatoire</p>');
				$('#secteur_activite').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#secteur_activite").find('.text-danger').remove();
				// success out for form 
				$("#secteur_activite").closest('.form-group').addClass('has-success');	  	
			}
			if(nom_societe && siegle_societe && tele_societe && pays && province && commune_societe && quartier && avenue && numero && email_societe  && assujetti_tva && NIF_societe && Registre_commerce && centre_fiscal && forme_juridique && secteur_activite ) {
				var form = $(this);
				// button loading
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						$("#createSocieteBtn").button('reset');

						if(response.success == true) {
	  	  					// reset the form text
							$("#getSocieteInfomationForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#societeModal").show("hide");
	  	  			
	  	  					$('#add-societe-messages').html('<div class="alert alert-success">'+
	            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	           					 '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          				'</div>'
		          			);

	  	  					$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
						}  // if
						else{
							$('#add-societe-messages').html('<div class="alert alert-danger">'+
	            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            				'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		         				'</div>'
		         			);

	  	  					$(".alert-danger").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
						}
					}

				}); // /ajax	
			} // if

			return false;

		});
	});

}

});

function editSociete(societeId = null){
	if(societeId) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editSocieteInfomationForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSociete.php',
				type: 'post',
				data: {societeId: societeId},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result


					$("#nom_societeEdit").val(response.order[0]);
					$("#siegle_societeEdit").val(response.order[1]);
					$("#tele_societEdite").val(response.order[2]);
					$("#tele_societeSecondEdit").val(response.order[3]);
					$("#bpEdit").val(response.order[4]);
					$("#paysEdit").val(response.order[5]);
					$("#provinceEdit").val(response.order[6]);
					$("#commune_societeEdit").val(response.order[7]);
					$("#quartierEdit").val(response.order[8]);
					$("#avenueEdit").val(response.order[9]);
					$("#numeroEdit").val(response.order[10]);

					
					$("#email_societeEdit").val(response.order[11]);
					$("#assujetti_tvaEdit").val(response.order[12]);
					$("#NIF_societeEdit").val(response.order[13]);
					$("#Registre_commerceEdit").val(response.order[14]);
					$("#centre_fiscalEdit").val(response.order[15]);
					$("#forme_juridiqueEdit").val(response.order[16]);
					$("#secteur_activiteEdit").val(response.order[17]);

					$("#societeModalEdit").modal('show');

							// submit categories form function



			$("#editSocieteModalBtn").unbind('click').bind('click', function() {

			$("#editSocieteInfomationForm").unbind('submit').bind('submit', function() {

			var nom_societe 		= $("#nom_societe").val();
			var siegle_societe 		= $("#siegle_societe").val();
			var tele_societe 		= $("#tele_societe").val();
			var pays 				= $("#pays").val();
			var province 			= $("#province").val();
			var commune_societe 	= $("#commune_societe").val();
			var tele_societeSecond 	= $("#tele_societeSecond").val();
			var quartier 			= $("#quartier").val();
			var avenue 				= $("#avenue").val();
			var numero 				= $("#numero").val();
			var tele_societe2 		= $("#tele_societe2").val();
			var bp 					= $("#bp").val();
			var email_societe 		= $("#email_societe").val();
			var assujetti_tva 		= $("#assujetti_tva").val();
			var NIF_societe 		= $("#NIF_societe").val();
			var Registre_commerce 	= $("#Registre_commerce").val();
			var centre_fiscal 		= $("#centre_fiscal").val();
			var forme_juridique 	= $("#forme_juridique").val();
			var secteur_activite 	= $("#secteur_activite").val();
			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

			if(nom_societe == "") {
				$("#nom_societe").after('<p class="text-danger">Ce champ  est obligatoire</p>');
				$('#nom_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#nom_societe").find('.text-danger').remove();
				// success out for form 
				$("#nom_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(siegle_societe == "") {
				$("#siegle_societe").after('<p class="text-danger">Siègle est obligatoire</p>');
				$('#siegle_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#siegle_societe").find('.text-danger').remove();
				// success out for form 
				$("#siegle_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(tele_societe == "" || tele_societe.match(phoneno)) {
				$("#tele_societe").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#tele_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_societe").find('.text-danger').remove();
				// success out for form 
				$("#tele_societe").closest('.form-group').addClass('has-success');	  	
			}

			if(pays == "") {
				$("#pays").after('<p class="text-danger">Pays est obligatoire</p>');
				$('#pays').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#pays").find('.text-danger').remove();
				// success pays for form 
				$("#pays").closest('.form-group').addClass('has-success');	  	
			}
			if(province == "") {
				$("#province").after('<p class="text-danger">Province est obligatoire</p>');
				$('#province').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#province").find('.text-danger').remove();
				// success out for form 
				$("#province").closest('.form-group').addClass('has-success');	  	
			}
			if(commune_societe == "") {
				$("#commune_societe").after('<p class="text-danger">Commune est obligatoire</p>');
				$('#commune_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#commune_societe").find('.text-danger').remove();
				// success out for form 
				$("#commune_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(quartier == "") {
				$("#quartier").after('<p class="text-danger">Quartier est obligatoire</p>');
				$('#quartier').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quartier").find('.text-danger').remove();
				// success out for form 
				$("#quartier").closest('.form-group').addClass('has-success');	  	
			}
			if(avenue == "") {
				$("#avenue").after('<p class="text-danger">Avenue est obligatoire</p>');
				$('#avenue').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#avenue").find('.text-danger').remove();
				// success out for form 
				$("#avenue").closest('.form-group').addClass('has-success');	  	
			}
			if(numero == "") {
				$("#numero").after('<p class="text-danger">Numéro est obligatoire</p>');
				$('#numero').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#numero").find('.text-danger').remove();
				// success out for form 
				$("#numero").closest('.form-group').addClass('has-success');	  	
			}

			if(email_societe == "") {
				$("#email_societe").after('<p class="text-danger">E-mail est obligatoire</p>');
				$('#email_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#email_societe").find('.text-danger').remove();
				// success out for form 
				$("#email_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(assujetti_tva == "") {
				$("#assujetti_tva").after('<p class="text-danger">TVA est obligatoire</p>');
				$('#assujetti_tva').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#assujetti_tva").find('.text-danger').remove();
				// success out for form 
				$("#assujetti_tva").closest('.form-group').addClass('has-success');	  	
			}
			if(NIF_societe == "") {
				$("#NIF_societe").after('<p class="text-danger">NIF est obligatoire</p>');
				$('#NIF_societe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#NIF_societe").find('.text-danger').remove();
				// success out for form 
				$("#NIF_societe").closest('.form-group').addClass('has-success');	  	
			}
			if(Registre_commerce == "") {
				$("#Registre_commerce").after('<p class="text-danger">RC est obligatoire</p>');
				$('#Registre_commerce').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#Registre_commerce").find('.text-danger').remove();
				// success out for form 
				$("#Registre_commerce").closest('.form-group').addClass('has-success');	  	
			}
			if(centre_fiscal == "") {
				$("#centre_fiscal").after('<p class="text-danger">Centre Fiscal est obligatoire</p>');
				$('#centre_fiscal').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#centre_fiscal").find('.text-danger').remove();
				// success out for form 
				$("#centre_fiscal").closest('.form-group').addClass('has-success');	  	
			}
			if(forme_juridique == "") {
				$("#forme_juridique").after('<p class="text-danger">Forme Juridique est obligatoire</p>');
				$('#forme_juridique').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#forme_juridique").find('.text-danger').remove();
				// success out for form 
				$("#forme_juridique").closest('.form-group').addClass('has-success');	  	
			}
			if(secteur_activite == "") {
				$("#secteur_activite").after('<p class="text-danger">Secteur d\'Activite est obligatoire</p>');
				$('#secteur_activite').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#secteur_activite").find('.text-danger').remove();
				// success out for form 
				$("#secteur_activite").closest('.form-group').addClass('has-success');	  	
			}
			if(nom_societe && siegle_societe && tele_societe && pays && province && commune_societe && quartier && avenue && numero && email_societe  && assujetti_tva && NIF_societe && Registre_commerce && centre_fiscal && forme_juridique && secteur_activite ) {
				var form = $(this);

				// button loading
				

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#editSocieteBtn").button('reset');

						if(response.success == true) {
												

	  	  					// reset the form text
							$("#editSocieteInfomationForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#societeModalEdit").show("hide");
	  	  			
	  	  					$('#add-societe-messages').html('<div class="alert alert-success">'+
	            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	           					 '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          				'</div>'
		          			);

	  	  					$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
						}  // if
						else{
							$('#add-societe-messages').html('<div class="alert alert-danger">'+
	            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            				'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		         				'</div>'
		         			);

	  	  					$(".alert-danger").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
						}
					}

				}); // /ajax	
			} // if

			return false;

		});


							});


					}
				}); // /ajax	
			} // if
	}

	
