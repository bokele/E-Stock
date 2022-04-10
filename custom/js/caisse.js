var manageCaisseTable;
$(document).ready(function() {
	// top bar active
	$('#navDepense').addClass('active');
	$('#topNavManageCaisse').addClass('active');
	
	$("#date_caisse").datepicker();
		// manage brand table
	manageCaisseTable = $("#manageCaisseTable").DataTable({
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
		'ajax': 'php_action/fetchCaisse.php',
		"columnDefs":[  
                {  
                    "targets":[1,2],  
                    "orderable":false,
                    
                },  
           ],

	});

	// submit brand form function
	$("#submitCaisseForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var date_caisse = $("#date_caisse").val();

		if(date_caisse == "") {
			$("#date_caisse").after('<p class="text-danger">Obligatoire</p>');
			$('#date_caisse').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#date_caisse").find('.text-danger').remove();
			// success out for form 
			$("#date_caisse").closest('.form-group').addClass('has-success');	  	
		}

			if(date_caisse) {
			var form = $(this);
			// button loading
			$("#createCaisseBtn").button('loading');
			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createCaisseBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageCaisseTable.ajax.reload(null, false);						
						$("#addCaisseModel").modal("hide");
  	  			// reset the form text
						$("#submitCaisseForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('#add-brand-messages').html('<div class="alert alert-success">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="fa fa-check "></i></strong> '+ response.messages +
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
           				 	'<strong><i class="fa fa-exclamation-triangle"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} // else return false marque existe

				} // /success
			}); // /ajax


		}
		return false;
	});

});
