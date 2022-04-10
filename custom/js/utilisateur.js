var manageUtlisateurTable;
var manageUtlisateurTableOnline;

$(document).ready(function() {
	// active top navbar categories
	$('#navUser').addClass('active');	
var divRequest = $(".div-request").text();
if(divRequest == 'addUser')  {
	$('#topNavAddUser').addClass('active');

	manageUtlisateurTable = $('#manageUtlisateurTable').DataTable({
		'ajax' : 'php_action/fetchUtlisateur.php',
		'order': [],
		"columnDefs":[  
                {  
                    "targets":[2,3,5,6],  
                    "orderable":false,  
                },  
           ]
	}); // manage categories Data Table






	// active top navbar categories

	// on click on submit categories form modal
	$('#addutilisateurModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#submitUtilisateurForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#submitUtilisateurForm").unbind('submit').bind('submit', function() {

			var id_agence 		= $("#id_agence").val();
			var username 		= $("#username").val();
			var email 			= $("#email").val();
			var role 			= $("#role").val();
			var status 			= $("#status").val();
			var telephone 		= $("#telephone").val();
			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
			if(id_agence == "") {
				$("#id_agence").after('<p class="text-danger">Agence est obligatoire</p>');
				$('#id_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_agence").find('.text-danger').remove();
				// success out for form 
				$("#id_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(username == "") {
				$("#username").after('<p class="text-danger">Nom est obligatoire</p>');
				$('#username').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#username").find('.text-danger').remove();
				// success out for form 
				$("#username").closest('.form-group').addClass('has-success');	  	
			}
			if(telephone == "") {
				$("#telephone").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#telephone').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#telephone").find('.text-danger').remove();
				// success out for form 
				$("#telephone").closest('.form-group').addClass('has-success');	  	
			}

			if(role == "") {
				$("#role").after('<p class="text-danger">Rôle est obligatoire</p>');
				$('#role').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#role").find('.text-danger').remove();
				// success out for form 
				$("#role").closest('.form-group').addClass('has-success');	  	
			}

			if(status == "") {
				$("#status").after('<p class="text-danger">Status est obligatoire</p>');
				$('#status').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#status").find('.text-danger').remove();
				// success out for form 
				$("#status").closest('.form-group').addClass('has-success');	  	
			}
			if(username && telephone && role && status) {
				var form = $(this);

				// button loading
				//$("#createUtlisateurBtn").button('loading');

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#createUtlisateurBtn").button('reset');

						if(response.success == true) {
							// reload the manage member table 
							manageUtlisateurTable.ajax.reload(null, false);						

	  	  					// reset the form text
							$("#submitUtilisateurForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');
	  	  			
	  	  					$('#add-utlisateur-messages').html('<div class="alert alert-success">'+
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
							$('#add-utlisateur-messages').html('<div class="alert alert-danger">'+
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

	}); // submit categories form function
	}); // /on click on submit categories form modal	
}else if (divRequest == 'manOnline') {
	$('#topNavManageUsers').addClass('active');
		manageUtlisateurTableOnline = $('#manageUtlisateurTableConnection').DataTable({
		'ajax' : 'php_action/fetOnlineUsers.php',
		'order': [],
		"columnDefs":[  
                {  
                    "targets":[1,2,3],  
                    "orderable":false,  
                },  
           ]
	}); // manage categories Data Table
}
}); // /document

// edit categories function
function editUtlisateur(utilisateurId = null) {
	if(utilisateurId) {
		// remove the added categories id 
		$('#editUtlisateurId').remove();
		// reset the form text
		$("#editUtilisateurForm")[0].reset();
		// reset the form text-error
		$(".text-danger").remove();
		// reset the form group errro		
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// edit categories messages
		$("#edit-categories-messages").html("");
		// modal spinner
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-categories-result').addClass('div-hide');
		//modal footer
		$(".editCategoriesFooter").addClass('div-hide');		

		$.ajax({
			url: 'php_action/fetchSelectedutlisateur.php',
			type: 'post',
			data: {utilisateurId: utilisateurId},
			dataType: 'json',
			success:function(response) {

				// modal spinner
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-utilisateur-result').removeClass('div-hide');
				//modal footer
				$(".editUtilisateurFooter").removeClass('div-hide');	

				// set the utlisateur agence
				$("#editId_agence").val(response.id_agence);
				// set the utlisateur name
				$("#editUsername").val(response.username);
				// set the utlisateur status
				$("#editEmail").val(response.email);
				// set the utlisateur name
				$("#editTelephone").val(response.telephone);
				// set the utlisateur status
				$("#editRole").val(response.role);
				// set the utlisateur status
				$("#editStatus").val(response.status);
				// add the utlisateur id 
				$(".editUtilisateurFooter").after('<input type="hidden" name="editUtilsateurId" id="editUtilsateurId" value="'+response.user_id+'" />');


				// submit of edit utlisateur form
				$("#editUtilisateurForm").unbind('submit').bind('submit', function() {
					var editId_agence 	= $("#editId_agence").val();
					var editUsername 	= $("#editUsername").val();
					var editEmail 		= $("#editEmail").val();
					var editTelephone 	= $("#editTelephone").val();
					var editRole 		= $("#editRole").val();
					var editStatus 		= $("#editStatus").val();
					
					if(editId_agence == "") {
						$("#editId_agence").after('<p class="text-danger">Agence est obligatoire</p>');
						$('#editId_agence').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editId_agence").find('.text-danger').remove();
						// success out for form 
						$("#editId_agence").closest('.form-group').addClass('has-success');	  	
					}
					if(editUsername == "") {
						$("#editUsername").after('<p class="text-danger">Nom est obligatoire</p>');
						$('#editUsername').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editUsername").find('.text-danger').remove();
						// success out for form 
						$("#editUsername").closest('.form-group').addClass('has-success');	  	
					}
					if(editTelephone == "") {
						$("#editTelephone").after('<p class="text-danger">Téléphone est obligatoire</p>');
						$('#editTelephone').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editTelephone").find('.text-danger').remove();
						// success out for form 
						$("#editTelephone").closest('.form-group').addClass('has-success');	  	
					}

					if(editRole == "") {
						$("#editRole").after('<p class="text-danger">Rôle est obligatoire</p>');
						$('#editRole').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editRole").find('.text-danger').remove();
						// success out for form 
						$("#editRole").closest('.form-group').addClass('has-success');	  	
					}

					if(editStatus == "") {
						$("#editStatus").after('<p class="text-danger">Status est obligatoire</p>');
						$('#editStatus').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editStatus").find('.text-danger').remove();
						// success out for form 
						$("#editStatus").closest('.form-group').addClass('has-success');	  	
					}

					if(editUsername && editTelephone && editRole && editStatus  && editId_agence ) {
				var form = $(this);
						// button loading
						$("#editCategoriesBtn").button('loading');

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								// button loading
								$("#editCategoriesBtn").button('reset');

								if(response.success == true) {
									// reload the manage member table 
									manageUtlisateurTable.ajax.reload(null, false);									  	  			
									
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  					$('#edit-utilisateur-messages').html('<div class="alert alert-success">'+
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
									$('#edit-utilisateur-messages').html('<div class="alert alert-danger">'+
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
							} // /success
						}); // /ajax	
					} // if
					return false;
				}); // /submit of edit categories form

			} // /success
		}); // /fetch the selected categories data

	} else {
		alert('Oops!! Refresh the page');
	}
} // /edit categories function

function removeUtilisateur(utilisateurId = null) {
		
	$.ajax({
		url: 'php_action/fetchSelectedutlisateur.php',
		type: 'post',
		data: {utilisateurId: utilisateurId},
		dataType: 'json',
		success:function(response) {		

			$("#utlisateurInfo").html('<h3>'+response.username+'</h3>');
				
			// remove categories btn clicked to remove the categories function
			$("#removeCategoriesBtn").unbind('click').bind('click', function() {
				// remove categories btn
				$("#removeCategoriesBtn").button('loading');

				$.ajax({
					url: 'php_action/removeUtilisateur.php',
					type: 'post',
					data: {utilisateurId: utilisateurId},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {
 							// remove categories btn
							$("#removeCategoriesBtn").button('reset');
							// close the modal 
							$("#removeCategoriesModal").modal('hide');
							// update the manage categories table
							manageUtlisateurTable.ajax.reload(null, false);
							// udpate the messages
							$('.remove-messages').html('<div class="alert alert-success">'+
	            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	           					'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          				'</div>'
		          			);

	  	  					$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
 						} else {
 							// close the modal 
							$("#removeCategoriesModal").modal('hide');

 							// udpate the messages
							$('.remove-messages').html('<div class="alert alert-success">'+
	           				 '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            				'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          			'</div>');

	  	  					$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert
 						} // /else
						
						
					} // /success function
				}); // /ajax function request server to remove the categories data
			}); // /remove categories btn clicked to remove the categories function

		} // /response
	}); // /ajax function to fetch the categories data
} // remove categories function