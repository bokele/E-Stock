var manageAgenceTable;

$(document).ready(function() {
	// top bar active

	$('#navUser').addClass('active');	

	var divRequest = $(".div-request").text();
		if(divRequest == 'agence')  {
			$('#topNavAgence').addClass('active');	
	
	// manage brand table
	manageAgenceTable = $("#manageAgenceTable").DataTable({
		'order': [],
		/*"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 50,
		"dom": '<"top"f>rtip',*/
		'ajax': 'php_action/fetchAgence.php',
		"columnDefs":[  
                {  
                    "targets":[1,3,4],  
                    "orderable":false,    
                },  
           ],
	});

	
	// on click on submit categories form modal
	$('#addAgenceModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#getAgenceInfomationForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#getAgenceInfomationForm").unbind('submit').bind('submit', function() {

			

			var agence 				= $("#agence").val();
			var tele_agence 		= $("#tele_agence").val();
			var province_agence 	= $("#province_agence").val();
			var commune_agence 		= $("#commune_agence").val();
			var quartier_agence 	= $("#quartier_agence").val();
			var avenue_agence 		= $("#avenue_agence").val();
			var numero_agence 		= $("#numero_agence").val();
			var resp_agence 		= $("#resp_agence").val();
			var tele_resp_agence 	= $("#tele_resp_agence").val();

			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

			if(agence == "") {
				$("#agence").after('<p class="text-danger">Le nom del\'agence  est obligatoire</p>');
				$('#agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#agence").find('.text-danger').remove();
				// success out for form 
				$("#agence").closest('.form-group').addClass('has-success');	  	
			}
	
			if(tele_agence == "" || tele_agence.match(phoneno)) {
				$("#tele_agence").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#tele_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_agence").find('.text-danger').remove();
				// success out for form 
				$("#tele_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(province_agence == "" ) {
				$("#province_agence").after('<p class="text-danger">Province est obligatoire</p>');
				$('#province_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#province_agence").find('.text-danger').remove();
				// success out for form 
				$("#province_agence").closest('.form-group').addClass('has-success');	  	
			}
		
			if(commune_agence == "") {
				$("#commune_agence").after('<p class="text-danger">Communee est obligatoire</p>');
				$('#commune_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#commune_agence").find('.text-danger').remove();
				// success commune_agence for form 
				$("#commune_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(quartier_agence == "") {
				$("#quartier_agence").after('<p class="text-danger">Quartier est obligatoire</p>');
				$('#quartier_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quartier_agence").find('.text-danger').remove();
				// success out for form 
				$("#quartier_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(avenue_agence == "") {
				$("#avenue_agence").after('<p class="text-danger">Avenue est obligatoire</p>');
				$('#avenue_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#avenue_agence").find('.text-danger').remove();
				// success out for form 
				$("#avenue_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(numero_agence == "") {
				$("#numero_agence").after('<p class="text-danger">Numéro est obligatoire</p>');
				$('#numero_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#numero_agence").find('.text-danger').remove();
				// success out for form 
				$("#numero_agence").closest('.form-group').addClass('has-success');	  	
			}
		
			if(resp_agance == "") {
				$("#resp_agence").after('<p class="text-danger">Nom du responsable est obligatoire</p>');
				$('#resp_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#resp_agence").find('.text-danger').remove();
				// success out for form 
				$("#resp_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(tele_resp_agence == "") {
				$("#tele_resp_agence").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#tele_resp_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_resp_agence").find('.text-danger').remove();
				// success out for form 
				$("#tele_resp_agence").closest('.form-group').addClass('has-success');	  	
			}

			
			if(agence && tele_agence  && province_agence && commune_agence && quartier_agence && avenue_agence && numero_agence && resp_agence && tele_resp_agence) {
				var form = $(this);
				// button loading

					$("#createAgenceBtn").button('loading');
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						$("#createAgenceBtn").button('reset');

						if(response.success == true) {

							manageAgenceTable.ajax.reload(null, false);		
	  	  					// reset the form text
							$("#getAgenceInfomationForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#agenceModal").show("hide");
	  	  			
	  	  					$('#add-agence-messages').html('<div class="alert alert-success">'+
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
							$('#add-agence-messages').html('<div class="alert alert-danger">'+
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

function editAgence(id_agence = null){
	if(id_agence) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editAgenceInfomationForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSelectedAgence.php',
				type: 'post',
				data: {id_agence: id_agence},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#nom_agence").text(response.agence);
					$("#agenceIdEdit").val(response.id_agence);
					$("#agenceEdit").val(response.agence);
					$("#tele_agenceEdit").val(response.tele_agence);
					$("#province_agenceEdit").val(response.province_agence);
					$("#commune_agenceEdit").val(response.commune_agence);
					$("#quartier_agenceEdit").val(response.quartier_agence);
					$("#avenue_agenceEdit").val(response.avenue_agence);
					$("#provinceEdit").val(response.province);
					$("#numero_agenceEdit").val(response.numero_agence);
					$("#resp_aganceEdit").val(response.resp_agence);
					$("#tele_resp_agenceEdit").val(response.tele_resp_agence);
					

					
					
					$("#agenceModalEdit").modal('show');

							// submit categories form function

	


			$("#editAgencModalBtn").unbind('click').bind('click', function() {

			$("#editAgenceInfomationForm").unbind('submit').bind('submit', function() {

			var agence 				= $("#agenceEdit").val();
			var tele_agence 		= $("#tele_agenceEdit").val();
			var province_agence 	= $("#province_agenceEdit").val();
			var commune_agence 		= $("#commune_agenceEdit").val();
			var quartier_agence 	= $("#quartier_agenceEdit").val();
			var avenue_agence 		= $("#avenue_agenceEdit").val();
			var numero_agence 		= $("#numero_agenceEdit").val();
			var resp_agance 		= $("#resp_aganceEdit").val();
			var tele_resp_agence 	= $("#tele_resp_agenceEdit").val();
			var agenceIdEdit 		= $("#agenceIdEdit").val();

			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

			if(agence == "") {
				$("#agence").after('<p class="text-danger">Ce champ  est obligatoire</p>');
				$('#agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#agence").find('.text-danger').remove();
				// success out for form 
				$("#agence").closest('.form-group').addClass('has-success');	  	
			}
			if(tele_agence == ""  || tele_agence.match(phoneno)) {
				$("#tele_agence").after('<p class="text-danger">Siègle est obligatoire</p>');
				$('#tele_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_agence").find('.text-danger').remove();
				// success out for form 
				$("#tele_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(province_agence == "") {
				$("#province_agence").after('<p class="text-danger">Téléphone est obligatoire</p>');
				$('#province_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#province_agence").find('.text-danger').remove();
				// success out for form 
				$("#province_agence").closest('.form-group').addClass('has-success');	  	
			}
		
			if(commune_agence == "") {
				$("#commune_agence").after('<p class="text-danger">Communee est obligatoire</p>');
				$('#commune_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#commune_agence").find('.text-danger').remove();
				// success commune_agence for form 
				$("#commune_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(quartier_agence == "") {
				$("#quartier_agence").after('<p class="text-danger">Province est obligatoire</p>');
				$('#quartier_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quartier_agence").find('.text-danger').remove();
				// success out for form 
				$("#quartier_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(avenue_agence == "") {
				$("#avenue_agence").after('<p class="text-danger">Commune est obligatoire</p>');
				$('#avenue_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#avenue_agence").find('.text-danger').remove();
				// success out for form 
				$("#avenue_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(numero_agence == "") {
				$("#numero_agence").after('<p class="text-danger">Quartier est obligatoire</p>');
				$('#numero_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#numero_agence").find('.text-danger').remove();
				// success out for form 
				$("#numero_agence").closest('.form-group').addClass('has-success');	  	
			}
		
			if(resp_agance == "") {
				$("#resp_agance").after('<p class="text-danger">Avenue est obligatoire</p>');
				$('#resp_agance').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#resp_agance").find('.text-danger').remove();
				// success out for form 
				$("#resp_agance").closest('.form-group').addClass('has-success');	  	
			}
			if(tele_resp_agence == "") {
				$("#tele_resp_agence").after('<p class="text-danger">Numéro est obligatoire</p>');
				$('#tele_resp_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#tele_resp_agence").find('.text-danger').remove();
				// success out for form 
				$("#tele_resp_agence").closest('.form-group').addClass('has-success');	  	
			}

			
			if(agence && tele_agence && province_agence && commune_agence && quartier_agence && avenue_agence && numero_agence && resp_agance && tele_resp_agence ) {
				var form = $(this);
				// button loading
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#ediotAgenceBtn").button('reset');

						if(response.success == true) {
							manageAgenceTable.ajax.reload(null, false);					
							
	  	  					// reset the form text
							$("#editAgenceInfomationForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#agenceModalEdit").show("hide");
	  	  			
	  	  					$('#add-agence-messages').html('<div class="alert alert-success">'+
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
							$('#add-agence-messages').html('<div class="alert alert-danger">'+
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

	function viewAgence(id_agence = null){
	if(id_agence) {
		
		 
			// active top navbar categories
			$('#navUser').addClass('active');	

			$("#editAgenceInfomationForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			$.ajax({
				url: 'php_action/fetchSelectedAgence.php',
				type: 'post',
				data: {id_agence: id_agence},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#nom_agenceInfo").text(response.agence);
					$("#agenceIdInfo").val(response.id_agence);
					$("#agenceInfo").val(response.agence);
					$("#tele_agenceInfo").val(response.tele_agence);
					$("#province_agenceInfo").val(response.province_agence);
					$("#commune_agenceInfo").val(response.commune_agence);
					$("#quartier_agenceInfo").val(response.quartier_agence);
					$("#avenue_agenceInfo").val(response.avenue_agence);
					$("#provinceInfo").val(response.province);
					$("#numero_agenceInfo").val(response.numero_agence);
					$("#resp_aganceInfo").val(response.resp_agence);
					$("#tele_resp_agenceInfo").val(response.tele_resp_agence);

					$("#agenceModalView").modal('show');
				}
			});
		}
	}
function removeAgence(id_agence = null) {
	if(id_agence) {
		$('#removeAgenceId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedAgence.php',
			type: 'post',
			data: {id_agence : id_agence},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeAgenceId" id="removeAgenceId" value="'+response.id_agence+'" /> ');
				$("#supprimer").text(response.agence);
				// click on remove button to remove the brand
				$("#removeAgenceBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeAgenceBtn").button('loading');

					$.ajax({
						url: 'php_action/removeAgence.php',
						type: 'post',
						data: {id_agence : id_agence},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeAgenceBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeAgenceModal').modal('hide');

								// reload the brand table 
								manageAgenceTable.ajax.reload(null, false);
								
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
	
