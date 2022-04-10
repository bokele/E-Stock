var manageVersementTable;

$(document).ready(function() {
	// top bar active
	$('#navDepense').addClass('active');
		$('#topNavManageVersement').addClass('active');	

		// order date picker
		$("#date_bordereau").datepicker();
	
	// manage brand table
	manageVersementTable = $("#manageVersementTable").DataTable({
		'order': [],
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 50,
		"dom": '<"top"f>rtip',
		'ajax': 'php_action/fetchVersement.php',
		"columnDefs":[  
                {  
                    "targets":[5],  
                    "orderable":false,
                    
                },  
           ],

	});


	// submit brand form function
	$("#submitVersementForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var id_banque 				= $("#id_banque").val();
		var numero_compte_banque 	= $("#numero_compte_banque").val();
		var nom_personne_verse 		= $("#nom_personne_verse").val();
		var montant_verse 			= $("#montant_verse").val();
		var date_bordereau 			= $("#date_bordereau").val();
		var numero_bordereau 		= $("#numero_bordereau").val();

		if(id_banque == "") {
			$("#id_banque").after('<p class="text-danger">Le nom de la banque est obligatoire</p>');
			$('#id_banque').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#id_banque").find('.text-danger').remove();
			// success out for form 
			$("#id_banque").closest('.form-group').addClass('has-success');	  	
		}
		if(numero_compte_banque == "") {
			$("#numero_compte_banque").after('<p class="text-danger">Le numéro du compte est obligatoire</p>');
			$('#numero_compte_banque').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#numero_compte_banque").find('.text-danger').remove();
			// success out for form 
			$("#numero_compte_banque").closest('.form-group').addClass('has-success');	  	
		}
		if(nom_personne_verse == "") {
			$("#nom_personne_verse").after('<p class="text-danger">Le nom de la personne qui a effectue l\'operation est obligatoire</p>');
			$('#nom_personne_verse').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_personne_verse").find('.text-danger').remove();
			// success out for form 
			$("#nom_personne_verse").closest('.form-group').addClass('has-success');	  	
		}
		if(montant_verse == "") {
			$("#montant_verse").after('<p class="text-danger">Le montant verse est obligatoire</p>');
			$('#montant_verse').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#montant_verse").find('.text-danger').remove();
			// success out for form 
			$("#montant_verse").closest('.form-group').addClass('has-success');	  	
		}
		if(date_bordereau == "") {
			$("#date_bordereau").after('<p class="text-danger">La date du bordereau est obligatoire</p>');
			$('#date_bordereau').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_badate_bordereaunque").find('.text-danger').remove();
			// success out for form 
			$("#date_bordereau").closest('.form-group').addClass('has-success');	  	
		}
		if(numero_bordereau == "") {
			$("#numero_bordereau").after('<p class="text-danger">Le numéro du bordereau est obligatoire</p>');
			$('#numero_bordereau').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#numero_bordereau").find('.text-danger').remove();
			// success out for form 
			$("#numero_bordereau").closest('.form-group').addClass('has-success');	  	
		}


		if(id_banque && numero_compte_banque && nom_personne_verse && montant_verse && date_bordereau && numero_bordereau ) {
			var form = $(this);
			// button loading
			$("#createVersementBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createVersementBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageVersementTable.ajax.reload(null, false);						

  	  			// reset the form text
						$("#submitVersementForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('#add-brand-messages').html('<div class="alert alert-success">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

					else{
						$('#add-brand-messages').html('<div class="alert alert-danger">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} // else return false marque existe

				} // /success
			}); // /ajax	
		} // if

		return false;
	}); // /submit brand form function

});

function viewVersement(versemntId = null) {
	if(versemntId) {
		$("#submitVersementViewForm")[0].reset();
		// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

		$.ajax({
			url: 'php_action/fetchSelectedVesermentDetail.php',
			type: 'post',
			data: {versemntId : versemntId},
			dataType: 'json',
			success:function(response) {

				$('.modal-loading').addClass('div-hide');

				$("#id_banqueEdit").val(response.id_banque);
				$("#montant_verseEdit").val(response.montant_verse);
				$("#numero_compte_banqueEdit").val(response.numero_compte_banque);
				$("#nom_personne_verseEdit").val(response.nom_personne_verse);
				$("#numero_bordereauEdit").val(response.numero_bordereau);
				$("#date_bordereauEdit").val(response.date_bordereau);
				$("#type_versementEdit").val(response.type_versement);
				
				$("#viewVersemntModel").modal("show");


			}

		});
	}
				
} // /edit brands function


