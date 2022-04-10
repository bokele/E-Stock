
var manageSousCompteTable;

$(document).ready(function() {
	// top bar active

	$('#navUser').addClass('active');	

	var divRequest = $(".div-request").text();
		if(divRequest == 'sousCompte')  {
			$('#navComptabilite').addClass('active');	
	
	// manage brand table
	manageSousCompteTable = $("#manageSousCompteTable").DataTable({
		'order': [],
		'ajax': 'php_action/fetchSousCompte.php',
		"columnDefs":[  
                {  
                    "targets":[3],  
                    "orderable":false,    
                },  
           ],
	});

		// on click on submit categories form modal
	$('#addSousCompteModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#getSousCompteForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#getSousCompteForm").unbind('submit').bind('submit', function() {

			

			var id_classe 				= $("#id_classe").val();
			var id_Compte 				= $("#id_Compte").val();
			var code_sous_compte 		= $("#code_sous_compte").val();
			var libelle_sous_compte 	= $("#libelle_sous_compte").val();

			if(id_classe == "") {
				$("#id_classe").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#id_classe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_classe").find('.text-danger').remove();
				// success out for form 
				$("#id_classe").closest('.form-group').addClass('has-success');	  	
			}

			if(id_Compte == "") {
				$("#id_Compte").after('<p class="text-danger">Le nom du compte  est obligatoire</p>');
				$('#id_Compte').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_Compte").find('.text-danger').remove();
				// success out for form 
				$("#id_Compte").closest('.form-group').addClass('has-success');	  	
			}

			if(code_sous_compte == "") {
				$("#code_sous_compte").after('<p class="text-danger">Le code du sous compte  est obligatoire</p>');
				$('#code_sous_compte').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#code_sous_compte").find('.text-danger').remove();
				// success out for form 
				$("#code_sous_compte").closest('.form-group').addClass('has-success');	  	
			}

			if(libelle_sous_compte == "") {
				$("#libelle_sous_compte").after('<p class="text-danger">Le nom du sous compte  est obligatoire</p>');
				$('#libelle_sous_compte').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_sous_compte").find('.text-danger').remove();
				// success out for form 
				$("#libelle_sous_compte").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if( id_classe && id_Compte && code_sous_compte &&  libelle_sous_compte ) {
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
						$("#createSousCompteBtn").button('reset');
						//$("#compteModal").show("hide");
						if(response.success == true) {

							manageSousCompteTable.ajax.reload(null, false);		
	  	  					// reset the form text
							$("#getSousCompteForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							
	  	  			
	  	  					$('#add-Souscompte-messages').html('<div class="alert alert-success">'+
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
							$('#add-Souscompte-messages').html('<div class="alert alert-danger">'+
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

function editSousCompte(id_sous_compte = null){
	if(id_sous_compte) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editSousCompteForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSelectedSousCompte.php',
				type: 'post',
				data: {id_sous_compte: id_sous_compte},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#libelle_sous_compteEdit").val(response.libelle_sous_compte);
					$("#code_sous_compteEdit").val(response.code_sous_compte);
					$("#id_classeEdit").val(response.id_classe);
					$("#id_CompteEdit").val(response.id_compte_principal);
					$("#id_compte_sousEdit").val(response.id_sous_compte);	
					//$("#code_sous_compteIdt").val(response.id_sous_compte);						
					
					$("#agenceModalEdit").modal('show');

							// submit categories form function

			$("#sousCompteEditModal").unbind('click').bind('click', function() {

			$("#editSousCompteForm").unbind('submit').bind('submit', function() {

			
			var id_classeEdit 				= $("#id_classeEdit").val();
			var id_CompteEdit 				= $("#id_CompteEdit").val();
			var code_sous_comptEdite 		= $("#code_sous_compteEdit").val();
			var libelle_sous_compteEdit 	= $("#libelle_sous_compteEdit").val();

			if(id_classEdite == "") {
				$("#id_classeEdit").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#id_classeEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_classeEdit").find('.text-danger').remove();
				// success out for form 
				$("#id_classeEdit").closest('.form-group').addClass('has-success');	  	
			}

			if(id_CompteEdit == "") {
				$("#id_CompteEdit").after('<p class="text-danger">Le nom du compte  est obligatoire</p>');
				$('#id_CompteEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_CompteEdit").find('.text-danger').remove();
				// success out for form 
				$("#id_CompteEdit").closest('.form-group').addClass('has-success');	  	
			}

			if(code_sous_compteEdit == "") {
				$("#code_sous_compteEdit").after('<p class="text-danger">Le code du sous compte  est obligatoire</p>');
				$('#code_sous_compteEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#code_sous_compteEdit").find('.text-danger').remove();
				// success out for form 
				$("#code_sous_compteEdit").closest('.form-group').addClass('has-success');	  	
			}

			if(libelle_sous_compteEdit == "") {
				$("#libelle_sous_compteEdit").after('<p class="text-danger">Le nom du sous compte  est obligatoire</p>');
				$('#libelle_sous_compteEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_sous_compteEdit").find('.text-danger').remove();
				// success out for form 
				$("#libelle_sous_compteEdit").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if( id_classeEdit && id_CompteEdit && code_sous_compteEdit &&  libelle_sous_compteEdit ) {
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
							$("#editSousCompteForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#sousCompteEditModal").show("hide");
	  	  			
	  	  					$('#add-sousClasse-messages').html('<div class="alert alert-success">'+
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
							$('#add-sousClasse-messages').html('<div class="alert alert-danger">'+
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




	function removSousCompte(id_sous_compte = null) {
	if(id_sous_compte) {
		$('#id_sous_compte').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedSousCompte.php',
			type: 'post',
			data: {id_sous_compte : id_sous_compte},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="id_sous_compte" id="id_sous_compte" value="'+response.id_sous_compte+'" /> ');
				$("#supprimer").text(response.libelle_sous_compte);
				// click on remove button to remove the brand
				$("#removeSousCompteBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeSousCompteBtn").button('loading');

					$.ajax({
						url: 'php_action/removeSousCompte.php',
						type: 'post',
						data: {id_sous_compte : id_sous_compte},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeSousCompteBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeClasseModal').modal('hide');

								// reload the brand table 
								manageSousCompteTable.ajax.reload(null, false);
								
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
	




function changeCompte(id_compte = null){
	var action = "id_classe";
	var id_classe = id_compte;
	$.ajax({
		url:"php_action/fetchProductData.php",
      	method:"POST",
		data:{id_classe:id_classe,action : action},
		dataType:"json",
		success:function(data){
			return data;
		}

	});
}