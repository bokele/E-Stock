var manageValeurAgenceTable;

$(document).ready(function() {
	// top bar active

	var divRequest = $(".div-request").text();
		if(divRequest == 'stockParAgence')  {
			$('#topNavManageAgenceStock').addClass('active');	
	

}	

		if(divRequest == 'stockAgence')  {

			$('#topNavManage').addClass('active');	
	



	// on click on submit categories form modal
	$('#addAgenceProductModalBtn').unbind('click').bind('click', function() {
		// reset the form text
		$("#submiAgencetProductForm")[0].reset();
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// submit categories form function
		$("#submiAgencetProductForm").unbind('submit').bind('submit', function() {

					
	  

			var id_agence 			= $("#id_agence").val();
			var id_agence_arrive 	= $("#id_agence_arrive").val();
			var brandName 			= $("#brandName").val();
			var categoryName 		= $("#categoryName").val();
			var produitName 		= $("#produitName").val();
			var quantity 			= $("#quantity").val();
			var quantiteStocksRest 	= $("#quantiteStocksRest").val();
			var stocksRest 			= $("#stocksRest").val();
			var prix_vente 			= $("#prix_vente").val();
			var prix_achat 			= $("#prix_achat").val();
			

			
			if(id_agence == "") {
				$("#id_agence").after('<p class="text-danger">Le nom de l\'agence  est obligatoire</p>');
				$('#id_agence').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_agence").find('.text-danger').remove();
				// success out for form 
				$("#id_agence").closest('.form-group').addClass('has-success');	  	
			}
			if(id_agence_arrive == "" || id_agence == id_agence_arrive) {
				$("#id_agence_arrive").after('<p class="text-danger">Le nom de l\'agence  est obligatoire</p>');
				$('#id_agence_arrive').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#id_agence_arrive").find('.text-danger').remove();
				// success out for form 
				$("#id_agence_arrive").closest('.form-group').addClass('has-success');	  	
			}
			if(brandName == "") {
				$("#brandName").after('<p class="text-danger">La marque est obligatoire</p>');
				$('#brandName').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#brandName").find('.text-danger').remove();
				// success out for form 
				$("#brandName").closest('.form-group').addClass('has-success');	  	
			}
			if(categoryName == "" ) {
				$("#categoryName").after('<p class="text-danger">La categorie est obligatoire</p>');
				$('#categoryName').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#categoryName").find('.text-danger').remove();
				// success out for form 
				$("#categoryName").closest('.form-group').addClass('has-success');	  	
			}
		
			if(produitName == "") {
				$("#produitName").after('<p class="text-danger">le produit est obligatoire</p>');
				$('#produitName').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#produitName").find('.text-danger').remove();
				// success commune_agence for form 
				$("#produitName").closest('.form-group').addClass('has-success');	  	
			}

			if(quantity == "") {
				$("#quantity").after('<p class="text-danger">la quantité  est obligatoire</p>');
				$('#quantity').closest('.form-group').addClass('has-error');
			} else {
				// remov error text field
				$("#quantity").find('.text-danger').remove();
				// success commune_agence for form 
				$("#quantity").closest('.form-group').addClass('has-success');	  	
			}

			if (id_agence == id_agence_arrive ) {
				
				$('#id_agence_arrive').closest('.form-group').addClass('has-error');
				$('#id_agence').closest('.form-group').addClass('has-error');
				$("#add-product-messages").html('<p class="alert alert-danger ">Les deux noms d\'agence de depart et de l\'agence d\'arrive  sont identique, veillez correige</p>');
				
			}else{

				if(id_agence && id_agence_arrive && brandName && categoryName && produitName && quantity) {
				var form = $(this);
				// button loading
				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						// button loading
						$("#addAgenceProductModalBtn").button('reset');

						if(response.success == true) {
	
	  	  					// reset the form text
							$("#submiAgencetProductForm")[0].reset();
							// remove the error text
							$(".text-danger").remove();
							// remove the form error
							$('.form-group').removeClass('has-error').removeClass('has-success');

							$("#add-productAgence-messages").show("hide");
	  	  			
	  	  					$('#add-productAgence-messages').html('<div class="alert alert-success">'+
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
							$('#add-productAgence-messages').html('<div class="alert alert-danger">'+
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
			}
			
			

			return false;

		});
	});

}

});


////////// Voir les information sur un produit dans une agence

function viewAgeenceProduct(produitAgence_id = null){
	if(produitAgence_id) {
		
		 
			// active top navbar categories
			$('#stockAgence').addClass('active');	

			$("#ViewAgencetProductForm")[0].reset();
			$("#nom_agene").text("");
			// remove the error text
			$(".text-danger").remove();
			// remove the form error
			$('.form-group').removeClass('has-error').removeClass('has-success');
			
			var resteQuantity = 0;
			var prix_total_vente_vendueView = 0;
			var prix_total_vente_resteView = 0;
			$.ajax({
				url: 'php_action/fetchSelectedProductAgence.php',
				type: 'post',
				data: {produitAgence_id: produitAgence_id},
				dataType: 'json',
				success:function(response) {

					// modal spinner
					$('.modal-loading').addClass('div-hide');
					// modal result
					$("#nom_agene").text(response.nom_agence);
					$("#id_agenceView").val(response.agence);

					$("#agenceIdInfo").val(response.produitAgence_id);
					$("#produitNameView").val(response.product_name);
					$("#piecesView").val(response.produit_pieceCarton);
					$("#rateView").val(response.prix_vente);
					$("#quantityTotalView").val(response.quantity_total_agence);
					$("#brandNameView").val(response.brand_name);
					$("#categoryNameView").val(response.categories_name);

					resteQuantity = (response.quantity_total_agence  - response.quantite); // quantite vendue

					$("#stocksRestAfficheView").val(response.quantite);
					//$("#quantiteVendueView").val(resteQuantity);
					$("#id_agence_arriveView").val(response.nom_agence);

					$("#prix_total_venteView").val(response.prix_total_vente);
					$("#benefice_totalView").val(response.benefice_total);

					//prix_total_vente_vendueView = (response.prix_vente  * quantity_total_agence);
					//$("#prix_total_vente_vendueView").val(prix_total_vente_vendueView);

					//prix_total_vente_resteView = (response.prix_vente * response.quantity_total_agence);
					//$("#prix_total_vente_resteView").val(prix_total_vente_resteView);
					
					$("#viewAgenceProductModal").modal('show');
				}
			});
		}
	}


