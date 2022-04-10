var manageBanqueTable;

$(document).ready(function() {
	// top bar active
	$('#navBanque').addClass('active');
	
	// manage brand table
	manageBanqueTable = $("#manageBanqueTable").DataTable({
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
		'ajax': 'php_action/fetchBanque.php',
		"columnDefs":[  
                {  
                    "targets":[1],  
                    "orderable":false,
                    
                },  
           ],

	});


	// submit brand form function
	$("#submitBanqueForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var nom_banque = $("#nom_banque").val();
		var brandStatus = $("#brandStatus").val();

		if(nom_banque == "") {
			$("#nom_banque").after('<p class="text-danger">Le nom de la banque est obligatoire</p>');
			$('#nom_banque').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_banque").find('.text-danger').remove();
			// success out for form 
			$("#nom_banque").closest('.form-group').addClass('has-success');	  	
		}


		if(nom_banque) {
			var form = $(this);
			// button loading
			$("#createBanqueBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createBanqueBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageBanqueTable.ajax.reload(null, false);						

  	  			// reset the form text
						$("#submitBanqueForm")[0].reset();
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

function editBanque(banqueId = null) {
	if(banqueId) {
		// remove hidden brand id text
		$('#banqueId').remove();

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
			url: 'php_action/fetchSelectedBanque.php',
			type: 'post',
			data: {banqueId : banqueId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-brand-result').removeClass('div-hide');
				// modal footer
				$('.editBrandFooter').removeClass('div-hide');

				// setting the brand name value 
				$('#editnom_banque').val(response.nom_banque);
				// setting the brand status value
				// brand id 
				$(".editBrandFooter").after('<input type="hidden" name="banqueId" id="banqueId" value="'+response.id_banque+'" />');

				// update brand form 
				$('#editBanqueForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');			

					var editnom_banque = $('#editnom_banque').val();
					

					if(editnom_banque == "") {
						$("#editnom_banque").after('<p class="text-danger">Le nom de la banque est obligatoire</p>');
						$('#editnom_banque').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editnom_banque").find('.text-danger').remove();
						// success out for form 
						$("#editnom_banque").closest('.form-group').addClass('has-success');	  	
					}

					if(editnom_banque) {
						var form = $(this);

						// submit btn
						$('#editBanqueBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									console.log(response);
									// submit btn
									$('#editBanqueBtn').button('reset');

									// reload the manage member table 
									manageBanqueTable.ajax.reload(null, false);								  	  										
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

function removeBanque(banqueId = null) {
	if(banqueId) {
		$('#removeBanqueId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedBanque.php',
			type: 'post',
			data: {banqueId : banqueId},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeBanqueId" id="removeBanqueId" value="'+response.brand_id+'" /> ');
				$("#supprimer").text(response.nom_banque);
				// click on remove button to remove the brand
				$("#removeBrandBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeBrandBtn").button('loading');

					$.ajax({
						url: 'php_action/removeBanque.php',
						type: 'post',
						data: {banqueId : banqueId},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeBrandBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeMemberModal').modal('hide');

								// reload the brand table 
								manageBanqueTable.ajax.reload(null, false);
								
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