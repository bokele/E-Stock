var manageClasseTable;

$(document).ready(function() {
	// top bar active

	$('#navUser').addClass('active');	

	var divRequest = $(".div-request").text();
		if(divRequest == 'classe')  {
			$('#navComptabilite').addClass('active');	
	
	// manage brand table
	manageClasseTable = $("#manageClasseTable").DataTable({
		'order': [],
		'ajax': 'php_action/fetchClasse.php',
		"columnDefs":[  
                {  
                    "targets":[1],  
                    "orderable":false,    
                },  
           ],
	});

		// on click on submit categories form modal
	$('#addClasseModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#getAClasseForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#getAClasseForm").unbind('submit').bind('submit', function() {

			var libelle_classe 	= $("#libelle_classe").val();

			if(libelle_classe == "") {
				$("#libelle_classe").after('<p class="text-danger">Le nom de classe  est obligatoire</p>');
				$('#libelle_classe').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_classe").find('.text-danger').remove();
				// success out for form 
				$("#libelle_classe").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if(libelle_classe ) {
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
						$("#addClasseModalBtn").button('reset');
						$("#classeModal").show("hide");
						if(response.success == true) {

							manageClasseTable.ajax.reload(null, false);		
	  	  					// reset the form text
							$("#getAClasseForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							
	  	  			
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

});


function editClasse(id_classe = null){
	if(id_classe) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editAClasseForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSelectedclasse.php',
				type: 'post',
				data: {id_classe: id_classe},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#libelle_classeEdit").val(response.libelle_classe);
					$("#id_classeEdit").val(response.id);					
					
					$("#agenceModalEdit").modal('show');

							// submit categories form function

			$("#removeAgenceModalBtn").unbind('click').bind('click', function() {

			$("#editAClasseForm").unbind('submit').bind('submit', function() {

			var libelle_classeEdit 	= $("#libelle_classeEdit").val();
			var id_classeEdit 		= $("#id_classeEdit").val();


			if(libelle_classeEdit == "") {
				$("#libelle_classeEdit").after('<p class="text-danger">Ce champ  est obligatoire</p>');
				$('#libelle_classeEdit').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#libelle_classeEdit").find('.text-danger').remove();
				// success out for form 
				$("#libelle_classeEdit").closest('.form-group').addClass('has-success');	  	
			}
			
			
			if(libelle_classeEdit && id_classeEdit ) {
				var form = $(this);
				// button loading
				

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#editClasseBtn").button('reset');

						if(response.success == true) {
							manageClasseTable.ajax.reload(null, false);					
							
	  	  					// reset the form text
							$("#editAClasseForm")[0].reset();
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


	function removeClasse(id_classe = null) {
	if(id_classe) {
		$('#removeClasseId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedclasse.php',
			type: 'post',
			data: {id_classe : id_classe},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeClasseId" id="removeClasseId" value="'+response.id+'" /> ');
				$("#supprimer").text(response.libelle_classe);
				// click on remove button to remove the brand
				$("#removeAgenceBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeAgenceBtn").button('loading');

					$.ajax({
						url: 'php_action/removeClasse.php',
						type: 'post',
						data: {id_classe : id_classe},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeAgenceBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeClasseModal').modal('hide');

								// reload the brand table 
								manageClasseTable.ajax.reload(null, false);
								
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
	
