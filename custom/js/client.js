var manageClientTable;

$(document).ready(function() {
	// top bar active
	$('#navUser').addClass('active');
		$('#navClient').addClass('active');	

	
	
	// manage brand table
	manageClientTable = $("#manageClientTable").DataTable({
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
		'ajax': 'php_action/fetchClient.php',
		"columnDefs":[  
                {  
                    "targets":[2,3,4],  
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

		var nom_client 				= $("#nom_client").val();
		var prenom_client 	= $("#prenom_client").val();
		var telephone_client 		= $("#telephone_client").val();
		var nif_client 			= $("#nif_client").val();
		var adresse_client 			= $("#adresse_client").val();
		//expression reg. telephone
			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

		if(nom_client == "") {
			$("#nom_client").after('<p class="text-danger">Le nom  est obligatoire</p>');
			$('#nom_client').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_client").find('.text-danger').remove();
			// success out for form 
			$("#nom_client").closest('.form-group').addClass('has-success');	  	
		}
		if(prenom_client == "") {
			$("#prenom_client").after('<p class="text-danger">Le prénom est obligatoire</p>');
			$('#prenom_client').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#prenom_client").find('.text-danger').remove();
			// success out for form 
			$("#prenom_client").closest('.form-group').addClass('has-success');	  	
		}
		if(telephone_client == "" || telephone_client.match(phoneno)) {
			$("#telephone_client").after('<p class="text-danger">Le téléphone est obligatoire</p>');
			$('#telephone_client').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#telephone_client").find('.text-danger').remove();
			// success out for form 
			$("#telephone_client").closest('.form-group').addClass('has-success');	  	
		}
		if(nif_client == "") {
			$("#nif_client").after('<p class="text-danger">Le NIF verse est obligatoire</p>');
			$('#nif_client').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nif_client").find('.text-danger').remove();
			// success out for form 
			$("#nif_client").closest('.form-group').addClass('has-success');	  	
		}
		if(adresse_client == "") {
			$("#adresse_client").after('<p class="text-danger">L\'adresse est obligatoire</p>');
			$('#adresse_client').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_baadresse_clientnque").find('.text-danger').remove();
			// success out for form 
			$("#adresse_client").closest('.form-group').addClass('has-success');	  	
		}



		if(nom_client && prenom_client && telephone_client && nif_client && adresse_client ) {
			var form = $(this);
			// button loading
			$("#createClientBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createClientBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageClientTable.ajax.reload(null, false);						

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

function editClient(clientId = null) {
	if(clientId) {
		// remove hidden brand id text
		$('#clientId').remove();

		// remove the error 
		$('.text-danger').remove();
		// remove the form-error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// modal loading
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-brand-result').addClass('div-hide');
		// modal footer
		$('.editBrandFooter').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedClient.php',
			type: 'post',
			data: {clientId : clientId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-brand-result').removeClass('div-hide');
				// modal footer
				$('.editBrandFooter').removeClass('div-hide');

				// setting the brand name value 
				$("#nom_clientEdit").val(response.nom_client);
				$("#prenom_clientEdit").val(response.prenom_client);
				$("#telephone_clientEdit").val(response.telephone_client);
				$("#nif_clientEdit").val(response.nif_client);
				$("#adresse_clientEdit").val(response.adresse_client);
				// setting the brand status value
				// brand id 
				$(".editBrandFooter").after('<input type="hidden" name="clientId" id="clientId" value="'+response.id_client+'" />');

				// update brand form 
				$('#submitClietEditForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');			

					var nom_clientEdit = $('#nom_clientEdit').val();
					var prenom_clientEdit = $('#prenom_clientEdit').val();
					var telephone_clientEdit = $('#telephone_clientEdit').val();
					var nif_clientEdit = $('#nif_clientEdit').val();
					var adresse_clientEdit = $('#adresse_clientEdit').val();
					var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

					if(nom_clientEdit == "") {
						$("#nom_clientEdit").after('<p class="text-danger">Le nom est obligatoire</p>');
						$('#nom_clientEdit').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#nom_clientEdit").find('.text-danger').remove();
						// success out for form 
						$("#nom_clientEdit").closest('.form-group').addClass('has-success');	  	
					}
					if(prenom_clientEdit == "") {
						$("#prenom_clientEdit").after('<p class="text-danger">Le prénom est obligatoire</p>');
						$('#prenom_clientEdit').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#prenom_clientEdit").find('.text-danger').remove();
						// success out for form 
						$("#prenom_clientEdit").closest('.form-group').addClass('has-success');	  	
					}if(telephone_clientEdit == "" || telephone_clientEdit.match(phoneno)) {
						$("#telephone_clientEdit").after('<p class="text-danger">Le téléphone est obligatoire</p>');
						$('#telephone_clientEdit').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#telephone_clientEdit").find('.text-danger').remove();
						// success out for form 
						$("#telephone_clientEdit").closest('.form-group').addClass('has-success');	  	
					}
					if(nif_clientEdit == "") {
						$("#nif_clientEdit").after('<p class="text-danger">Le NIF verse est obligatoire</p>');
						$('#nif_clientEdit').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#nif_clientEdit").find('.text-danger').remove();
						// success out for form 
						$("#nif_clientEdit").closest('.form-group').addClass('has-success');	  	
					}
					if(adresse_clientEdit == "") {
						$("#adresse_clientEdit").after('<p class="text-danger">L\'adresse est obligatoire</p>');
						$('#adresse_clientEdit').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#adresse_clientEdit").find('.text-danger').remove();
						// success out for form 
						$("#adresse_clientEdit").closest('.form-group').addClass('has-success');	  	
					}

					if(nom_clientEdit && prenom_clientEdit && telephone_clientEdit && nif_clientEdit && adresse_clientEdit) {
						var form = $(this);

						// submit btn
						$('#createClientEditBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									console.log(response);
									// submit btn
									$('#createClientEditBtn').button('reset');
									$("#viewVersementModel").modal("hide");
									// reload the manage member table 
									manageClientTable.ajax.reload(null, false);								  	  										
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  			$('#edit-brand-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								} else{
									$('#edit-brand-messages').html('<div class="alert alert-danger">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								}// /if
									
							}// /success
						});	 // /ajax												
					} // /if

					return false;
				}); // /update brand form

			} // /success
		}); // ajax function

	} else {
		alert('error!! Refresh the page again');
	}
} // /edit brands function
$(document).on("click","#btncancel",function(){
	
});

function removeClient(clientId = null) {
	if(clientId) {
		$('#removeClientId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedClient.php',
			type: 'post',
			data: {clientId : clientId},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeClientId" id="removeClientId" value="'+response.id_client+'" /> ');
				$("#supprimer").text(response.nom_client);
				// click on remove button to remove the brand
				$("#removeClientBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeClientBtn").button('loading');

					$.ajax({
						url: 'php_action/removeClient.php',
						type: 'post',
						data: {clientId : clientId},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeClientBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeMemberModal').modal('hide');

								// reload the brand table 
								manageClientTable.ajax.reload(null, false);
								
								$('.remove-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
							} else {

							} // /else
						} // /response messages
					}); // /ajax function to remove the brand

				}); // /click on remove button to remove the brand

			} // /success
		}); // /ajax

		$('.removeBrandFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove brands functionbanque