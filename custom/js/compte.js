
var manageCompteTable;

$(document).ready(function() {
	// top bar active

	$('#navUser').addClass('active');	

	var divRequest = $(".div-request").text();
		if(divRequest == 'commptePrincipal')  {
			$('#navComptabilite').addClass('active');	
	
	// manage brand table
	manageCompteTable = $("#manageCompteTable").DataTable({
		'order': [],
		'ajax': 'php_action/fetchCompte.php',
		"columnDefs":[  
                {  
                    "targets":[3],  
                    "orderable":false,    
                },  
           ],
	});

		// on click on submit categories form modal
	$('#addCompteModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#getCompteForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#getCompteForm").unbind('submit').bind('submit', function() {

			

			var id_classe 		= $("#id_classe").val();
			var code_compte 	= $("#code_compte").val();
			var libelle_compte 	= $("#libelle_compte").val();

			if(id_classe == "") {
				$("#id_classe").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#id_classe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_classe").find('.text-danger').remove();
				// success out for form 
				$("#id_classe").closest('.form-group').addClass('has-success');	  	
			}

			if(code_compte == "") {
				$("#code_compte").after('<p class="text-danger">Le code  est obligatoire</p>');
				$('#code_compte').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#code_compte").find('.text-danger').remove();
				// success out for form 
				$("#code_compte").closest('.form-group').addClass('has-success');	  	
			}

			if(libelle_compte == "") {
				$("#libelle_compte").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#libelle_compte').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_compte").find('.text-danger').remove();
				// success out for form 
				$("#libelle_compte").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if( id_classe && code_compte && libelle_compte ) {
				var form = $(this);
				// button loading

				
					//$("#createClasseBtn").button('loading');
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						$("#addCompteModalBtn").button('reset');
						$("#compteModal").show("hide");
						if(response.success == true) {

							manageCompteTable.ajax.reload(null, false);		
	  	  					// reset the form text
							$("#getCompteForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							
	  	  			
	  	  					$('#add-compte-messages').html('<div class="alert alert-success">'+
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
							$('#add-compte-messages').html('<div class="alert alert-danger">'+
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


function editCompte(id_compte = null){
	if(id_compte) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editACompteForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSelectedCompte.php',
				type: 'post',
				data: {id_compte: id_compte},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#libelle_compteEdit").val(response.libelle_compte);
					$("#code_compteEdit").val(response.code_compte);
					$("#id_classeEdit").val(response.id_classe);
					$("#id_compte_principalEdit").val(response.id_compte_principal);						
					
					$("#agenceModalEdit").modal('show');

							// submit categories form function

			$("#removeCompteModal").unbind('click').bind('click', function() {

			$("#editACompteForm").unbind('submit').bind('submit', function() {

			
			var id_classeEdit 		= $("#id_classeEdit").val();
			var code_compteEdit 	= $("#code_compteEdit").val();
			var libelle_compteEdit 	= $("#libelle_compteEdit").val();

			if(id_classeEdit == "") {
				$("#id_classeEdit").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#id_classeEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_classeEdit").find('.text-danger').remove();
				// success out for form 
				$("#id_classeEdit").closest('.form-group').addClass('has-success');	  	
			}

			if(code_compteEdit == "") {
				$("#code_compteEdit").after('<p class="text-danger">Le code  est obligatoire</p>');
				$('#code_compteEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#code_compteEdit").find('.text-danger').remove();
				// success out for form 
				$("#code_compte").closest('.form-group').addClass('has-success');	  	
			}

			if(libelle_compteEdit == "") {
				$("#libelle_compteEdit").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#libelle_compteEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_compteEdit").find('.text-danger').remove();
				// success out for form 
				$("#libelle_compteEdit").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if( id_classeEdit && code_compteEdit && libelle_compteEdit ) {
				var form = $(this);
				// button loading
				

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#editCompteBtn").button('reset');

						if(response.success == true) {
							manageCompteTable.ajax.reload(null, false);					
							
	  	  					// reset the form text
							$("#editACompteForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#classeEditModal").show("hide");
	  	  			
	  	  					$('#add-classe-messages').html('<div class="alert alert-success">'+
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
							$('#add-classe-messages').html('<div class="alert alert-danger">'+
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


	function removeCompte(id_compte = null) {
	if(id_compte) {
		$('#removeCompteId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedCompte.php',
			type: 'post',
			data: {id_compte : id_compte},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeCompteId" id="removeCompteId" value="'+response.id_compte_principal+'" /> ');
				$("#supprimer").text(response.libelle_compte);
				// click on remove button to remove the brand
				$("#removeAgenceBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeAgenceBtn").button('loading');

					$.ajax({
						url: 'php_action/removeCompte.php',
						type: 'post',
						data: {id_compte : id_compte},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeAgenceBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeClasseModal').modal('hide');

								// reload the brand table 
								manageCompteTable.ajax.reload(null, false);
								
								$('.add-classe-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
													$(this).delay(3000).hide(10, function() {
														$(this).remove();
													});
												}); // /.alert
							} else {
								$('.add-classe-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
													$(this).delay(3000).hide(10, function() {
														$(this).remove();
													});
												}); // /.alert
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
} // /remove brands function
	
