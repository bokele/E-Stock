var manageStockTable;

$(document).ready(function() {
	// top bar active

	$('#navProduct').addClass('active');	
	var divRequest = $(".div-request").text();
	if(divRequest == 'stock')  {
		$('#navstock').addClass('active');

			manageStockTable = $("#manageStockTable").DataTable({
			'ajax': 'php_action/fetchStock.php',
			'order': [],
			"columnDefs":[  
                {  
                     "targets":[5],  
                     "orderable":false,  
                },  
           ]
		});	

		// on click on submit categories form modal
			$('#addStockProductModalBtn').unbind('click').bind('click', function() {
			// reset the form text
			$("#stockProductForm")[0].reset();
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');

			// submit categories form function
			$("#stockProductForm").unbind('submit').bind('submit', function() {

				

				var brandName 		= $("#brandName").val();
				var categoryName 	= $("#categoryName").val();
				var produitNom 		= $("#produitNom").val();
				var quantity 		= $("#quantity").val();

				if(brandName == "") {
					$("#brandName").after('<p class="text-danger">Le fornisseur  est obligatoire</p>');
					$('#brandName').closest('.form-group').addClass('has-error');
				} else {
				// remov error text field
					$("#brandName").find('.text-danger').remove();
				// success out for form 
					$("#brandName").closest('.form-group').addClass('has-success');	  	
				}
				if(categoryName == "") {
					$("#categoryName").after('<p class="text-danger">La categories est obligatoire</p>');
					$('#categoryName').closest('.form-group').addClass('has-error');
				} else {
					// remov error text field
					$("#categoryName").find('.text-danger').remove();
					// success out for form 
					$("#categoryName").closest('.form-group').addClass('has-success');	  	
				}
				if(produitNom == "" ) {
					$("#produitNom").after('<p class="text-danger">le produit est obligatoire</p>');
					$('#produitNom').closest('.form-group').addClass('has-error');
				} else {
					// remov error text field
					$("#produitNom").find('.text-danger').remove();
					// success out for form 
					$("#produitNom").closest('.form-group').addClass('has-success');	  	
				}
				if(quantity == "" ) {
					$("#quantity").after('<p class="text-danger">La quantité est obligatoire</p>');
					$('#quantity').closest('.form-group').addClass('has-error');
				} else {
					// remov error text field
					$("#quantity").find('.text-danger').remove();
					// success out for form 
					$("#quantity").closest('.form-group').addClass('has-success');	  	
				}


			if(brandName && categoryName && produitNom && quantity) {
				var form = $(this);
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						$("#addAgenceModalBtn").button('reset');

						if(response.success == true) {

							manageStockTable.ajax.reload(null, false);		
	  	  					// reset the form text
							$("#stockProductForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#addStockProductModal").show("hide");

							//$(".submitButtonFooter").addClass('div-hide');
	  	  			
	  	  					$('#add-stock-messages').html('<div class="alert alert-success">'+
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
							$('#add-stock-messages').html('<div class="alert alert-danger">'+
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

			}

			return false;
			});
		});
	}

});

function viewStockProduct(productId = null){
	
	if(productId) {
		$.ajax({
			url: 'php_action/fetchStockDataDetail.php',
			type: 'post',
			data: {productId: productId},
			dataType: 'json',
			success:function(response){

				$("#tableDatail").html(response);
			}
		});
	}	
}

function editProductStock(product_id = null){
	if(product_id) {
		// active top navbar categories
		$('#navProduct').addClass('active');	

		$("#stockProductQuantiteForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		$.ajax({
			url: 'php_action/fetchSelectedStock.php',
			type: 'post',
			data: {product_id: product_id},
			dataType: 'json',
			success:function(response) {

				// modal spinner
				$('.modal-loading').addClass('div-hide');
				// modal result
				$("#product_name").val(response.product_name);
				$("#product_idStock").val(response.product_id);
				$("#quantiteStock").val(response.quantity_total);
				$("#quantiteStockValue").val(response.quantity_total);
				$("#dateValue").val(response.date_add);							
				
				$("#editStockModalView").modal('show');

				$("#stockProductQuantiteForm").unbind('submit').bind('submit', function() {

				var quantiteNew 	= $("#quantiteNew").val();
				if(quantiteNew == "") {
					$("#quantiteNew").after('<p class="text-danger">Obligatoire</p>');
					$('#quantiteNew').closest('.form-group').addClass('has-error');
				} else {
					// remov error text field
					$("#quantiteNew").find('.text-danger').remove();
					// success out for form 
					$("#quantiteNew").closest('.form-group').addClass('has-success');	  	
				}
				if(quantiteNew) {
					var form = $(this);
				// button loading		
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
							// button loading
						$("#quantiteStockBtn").button('reset');

						if(response.success == true) {
							manageStockTable.ajax.reload(null, false);					
							
	  	  					// reset the form text
							$("#stockProductQuantiteForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#editStockModalView").show("hide");
	  	  			
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
						}  // if
						else{
							$('.remove-messages').html('<div class="alert alert-danger">'+
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
				}
				return false;

			});
			
		}

	});

	}
}
