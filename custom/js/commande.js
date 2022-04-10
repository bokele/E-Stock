var manageCommandeTable;

$(document).ready(function() {

	$("#navDepense").addClass('active');
	$('#topNavManageCommande').addClass('active');
		// order date picker
		$("#date_commande").datepicker();

		var divRequest = $(".div-request").text();
					// manage brand table
	manageCommandeTable = $("#manageCommandeTable").DataTable({
		'ajax': 'php_action/fetchCommande.php',
		'order': [],
			"columnDefs":[  
                {  
                    "targets":[0,5],  
                    "orderable":false,  
                },  
           ]
	});
		if(divRequest == 'addCommande')  {



	// // product form reset
		$("#getCommandeForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

	$("#getCommandeForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

			var date_commande	= $("#date_commande").val();
			var id_marque 		= $("#id_marque").val();
			
	

		if(date_commande == "") {
			$("#date_commande").after('<p class="text-danger">obligatoire</p>');
			$('#date_commande').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#date_commande").find('.text-danger').remove();
			// success out for form 
			$("#date_commande").closest('.form-group').addClass('has-success');	  	
		}
		if(id_marque == "") {
			$("#id_marque").after('<p class="text-danger"> Obligatoire </p>');
			$('#id_marque').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#id_marque").find('.text-danger').remove();
			// success out for form 
			$("#id_marque").closest('.form-group').addClass('has-success');	  	
		}
		

		// array validation
			var productId = document.getElementsByName('productId[]');				
			var validateProduct;
			for (var x = 0; x < productId.length; x++) {       			
				var productIdId = productId[x].id;	    	
		    	if(productId[x].value == ''){	    		    	
		    		$("#"+productIdId+"").after('<p class="text-danger"> Obligatoire</p>');
		    		$("#"+productIdId+"").closest('.form-group').addClass('has-error');	    		    	    	
		      	} else {      	
			    	$("#"+productIdId+"").closest('.form-group').addClass('has-success');	    		    		    	
		      	}          
	   		} // for
	   			for (var x = 0; x < productId.length; x++) {       						
			    if(productId[x].value){	    		    		    	
			    	validateProduct = true;
		      } else {      	
			    	validateProduct = false;
		      }          
		   	} // for

		   	var quantite = document.getElementsByName('quantite[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantite.length; x++) {       
	 			var quantityId = quantite[x].id;
		    if(quantite[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantite.length; x++) {       						
		    if(quantite[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

	   		var prix_achat = document.getElementsByName('prix_achat[]');		   	
	   	var validatePrix;
	   	for (var x = 0; x < prix_achat.length; x++) {       
	 			var prix_achatId = prix_achat[x].id;
		    if(prix_achat[x].value == ''){	    	
		    	$("#"+prix_achatId+"").after('<p class="text-danger"></p>');
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   		for (var x = 0; x < prix_achat.length; x++) {       						
		    if(prix_achat[x].value){	    		    		    	
		    	validatePrix = true;
	      } else {      	
		    	validatePrix = false;
	      }          
	   	} // for

		if(date_commande && id_marque) {
			var form = $(this);
			// button loading
			if(validateProduct == true && validateQuantity == true && validatePrix == true) {

				$("#createCommandeBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createCommandeBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageCommandeTable.ajax.reload(null, false);						
						// hide the remove modal 
						$('#attacheFactureDepenseDepenseModal').modal('hide');
  	  					// reset the form text
						$("#getCommandeForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('.remove-messages').html('<div class="alert alert-success">'+
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
						$('.remove-messages').html('<div class="alert alert-danger">'+
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



			}return false;
}

return false;
});



}else if (divRequest == 'edit') {
		$("#editCommandeForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		// array validation
			var productId = document.getElementsByName('productId[]');				
			var validateProduct;
			for (var x = 0; x < productId.length; x++) {       			
				var productIdId = productId[x].id;	    	
		    	if(productId[x].value == ''){	    		    	
		    		$("#"+productIdId+"").after('<p class="text-danger"> Obligatoire</p>');
		    		$("#"+productIdId+"").closest('.form-group').addClass('has-error');	    		    	    	
		      	} else {      	
			    	$("#"+productIdId+"").closest('.form-group').addClass('has-success');	    		    		    	
		      	}          
	   		} // for
	   			for (var x = 0; x < productId.length; x++) {       						
			    if(productId[x].value){	    		    		    	
			    	validateProduct = true;
		      } else {      	
			    	validateProduct = false;
		      }          
		   	} // for

		   	var quantite = document.getElementsByName('quantite[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantite.length; x++) {       
	 			var quantityId = quantite[x].id;
		    if(quantite[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantite.length; x++) {       						
		    if(quantite[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

	   		var prix_achat = document.getElementsByName('prix_achat[]');		   	
	   	var validatePrix;
	   	for (var x = 0; x < prix_achat.length; x++) {       
	 			var prix_achatId = prix_achat[x].id;
		    if(prix_achat[x].value == ''){	    	
		    	$("#"+prix_achatId+"").after('<p class="text-danger"></p>');
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   		for (var x = 0; x < prix_achat.length; x++) {       						
		    if(prix_achat[x].value){	    		    		    	
		    	validatePrix = true;
	      } else {      	
		    	validatePrix = false;
	      }          
	   	} // for

			var form = $(this);
			// button loading
			if(validateProduct == true && validateQuantity == true && validatePrix == true) {

				$("#editCommandeBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#editCommandeBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageCommandeTable.ajax.reload(null, false);						
						// hide the remove modal 
						$('#attacheFactureDepenseDepenseModal').modal('hide');
  	  					// reset the form text
						$("#editCommandeForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();

						// disabled te modal footer button
						$(".editButtonFooter").addClass('div-hide');
						// remove the product row
						$(".removeCommandRowBtn").addClass('div-hide');
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('.remove-messages').html('<div class="alert alert-success">'+
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
						$('.remove-messages').html('<div class="alert alert-danger">'+
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



			}return false;

});
}

});

function addRow() {

	if ($("#id_marque").val() != "") {
		$("#addRowBtn").button("loading");

	var tableLength = $("#productTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		
		
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;
		
		if (tableLength == 10) {
		$("#addRowBtn").prop('disabled', true);
		//$("#addRowBtn").attr("disabled", "true");
						
	} 
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}


	var action = "id_marque";
	var id_marque =  $("#id_marque").val();
	$.ajax({
		url: 'php_action/fetchProductData.php',
		method:"POST",
		data:{id_marque:id_marque,action : action},
		dataType: 'json',
		success:function(response) {
			$("#addRowBtn").button("reset");			

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
				'<td style="margin-left:20px;">'+
					'<div class="form-group">'+

					'<select class="form-control" name="productId[]" id="productId'+count+'" onchange="getProductData('+count+')" >';//+
						
						
							tr += response; 						
						
													
					tr += '</select>'+
					
				'</td>'+
				'<td style="padding-left:20px;">'+
					'<input type="number" name="quantite[]" id="quantite'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
				'</td>'+
				''+
					''+
						'<input type="hidden" name="prix_achat[]" id="prix_achat'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
						'<input type="hidden" name="prix_achatValue[]" id="prix_achatValue'+count+'" autocomplete="off" class="form-control" />'+
					''+
				''+

				
				''+
					'<input type="hidden" name="prix_achat_total[]" id="prix_achat_total'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
					'<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue'+count+'" autocomplete="off" class="form-control" />'+
				''+
				'<td>'+
					'<button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeCommandRowBtn('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
				
			'</tr>';
			if(tableLength > 0) {							
				$("#productTable tbody tr:last").after(tr);
			} else {				
				$("#productTable tbody").append(tr);
			}		

		} // /success
	});	// get the product data
}else{
	alert("Le fournisseur est obligatoire ");
}
	

} // /add row


// table total
function getTotal(row = null) {
	if(row) {
		
		var total = Number($("#prix_achat"+row).val()) * Number($("#quantite"+row).val());

		total = total.toFixed(2);
		$("#prix_achat_total"+row).val(total);
		$("#prix_achat_totalValue"+row).val(total);

		subAmount();



	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
}

////////// remove row
function removeCommandRow(row = null) {
	if(row) {
		$("#row"+row).remove();
		subAmount();
	} else {
		alert('Erreur ! Actualiser à nouveau la page');
	}
}// fin remove row

//// get data from  product selected
function getProductData(row = null) {

	if(row) {
		var productId = $("#productId"+row).val();

		var id_marque = $("#id_marque").val();		
		
		if(productId == "") {
			$("#rate"+row).val("");

			$("#quantite"+row).val("");						
			$("#prix_achat"+row).val("");


		} else {
					$.ajax({
						url: 'php_action/fetchSelectedProduct.php',
						type: 'post',
						data: {productId : productId},
						dataType: 'json',
						success:function(response) {
							// setting the rate value into the rate input field
					
							$("#prix_achat"+row).val(response.prix_achat);
							$("#prix_achatValue"+row).val(response.prix_achat);

							

							$("#quantite"+row).val(1);

							var total = Number(response.prix_achat) * 1;
							total = total.toFixed(2);
							$("#prix_achat_total"+row).val(total);
							$("#prix_achat_totalValue"+row).val(total);
							
							 
								subAmount();
								//orderTVA();

							
						} // /success
					}); // /ajax function to fetch the product data	
						//tvaOuiNonTotal = $("#tvaOuiNonTotal").val(tvaOuiNon);
						

				
			
		}
				
	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
} // /select on product data

function subAmount() {
	var tableProductLength = $("#productTable tbody tr").length;
	var totalSubAmount = 0;
	var tvaOuiNon = "";
	var quantite =0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#productTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#prix_achat_total"+count).val());
		$("#quantite_totalAffiche").val(quantite);
		quantite += Number($("#quantite"+count).val());

	} // /for



	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#prix_total_achatAffiche").val(totalSubAmount);
	$("#prix_total_achatValue").val(totalSubAmount);
	$("#quantite_totalAffiche").val(quantite);
	$("#quantite_total").val(quantite);

}

function payementCommnade(id_commande = null) {
	if(id_commande) {
		$("#date_facture").datepicker();
		$.ajax({
			url: 'php_action/fetchSelectedCommande.php',
			type: 'post',
			data: {id_commande : id_commande},
			dataType: 'json',
			success:function(response) {
				$('#depensePayementId').val(response.id_commande);
				$("#paiement").text(response.ref_commande);
				$("#prix_achat_depense").val(response.prix_total_achat);
				$("#dateemission").val(response.date_commande);
				$("#prix_achat_depenseValue").val(response.prix_total_achat);
				// click on remove button to remove the brand
				$("#getpaiementCommandeForm").unbind('submit').bind('submit', function() {
					// button loading
					
					
					var date_facture 				= $("#date_facture").val();
					var facture_depense 			= $("#facture_depense").val();
					var id_classe 					= $("#id_classe").val();
					var id_Compte 					= $("#id_Compte").val();
					var id_sous_compte 				= $("#id_sous_compte").val();
					var paymentType 				= $("#paymentType").val();
					var paymentStatusPayement 		= $("#paymentStatusPayement").val();
					var montant 					= $("#montant").val();
					var prix_achat_depenseValue 	= $("#prix_achat_depenseValue").val();
					var observation_depense 		= $("#observation_depense").val();
					var depensePayementId 			= $("#depensePayementId").val();

					if(date_facture == "") {
						$("#date_facture").after('<p class="text-danger">La date est obligatoire</p>');
						$('#date_facture').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#date_facture").find('.text-danger').remove();
						// success out for form 
						$("#date_facture").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(facture_depense == "") {
						$("#facture_depense").after('<p class="text-danger">Le numéro est obligatoire</p>');
						$('#facture_depense').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#facture_depense").find('.text-danger').remove();
						// success out for form 
						$("#facture_depense").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_classe == "") {
						$("#id_classe").after('<p class="text-danger">La classe est obligatoire</p>');
						$('#id_classe').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_classe").find('.text-danger').remove();
						// success out for form 
						$("#id_classe").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_Compte == "") {
						$("#id_Compte").after('<p class="text-danger">Le compte est obligatoire</p>');
						$('#id_Compte').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_Compte").find('.text-danger').remove();
						// success out for form 
						$("#id_Compte").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_sous_compte == "") {
						$("#id_sous_compte").after('<p class="text-danger">Le sous compte est obligatoire</p>');
						$('#id_sous_compte').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_sous_compte").find('.text-danger').remove();
						// success out for form 
						$("#id_sous_compte").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(paymentType == "") {
						$("#paymentType").after('<p class="text-danger">Le type de paiement est obligatoire</p>');
						$('#paymentType').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#paymentType").find('.text-danger').remove();
						// success out for form 
						$("#paymentType").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(paymentStatusPayement == "") {
						$("#paymentStatusPayement").after('<p class="text-danger">Le status de paiement est obligatoire</p>');
						$('#paymentStatusPayement').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#paymentStatusPayement").find('.text-danger').remove();
						// success out for form 
						$("#paymentStatusPayement").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(montant == "") {
						$("#montant").after('<p class="text-danger">Le montant est obligatoire</p>');
						$('#montant').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#montant").find('.text-danger').remove();
						// success out for form 
						$("#montant").closest('.form-group').addClass('has-success');	  	
					}	// /else
						
					if(date_facture && facture_depense && id_classe && id_Compte && id_sous_compte && paymentType && paymentStatusPayement && montant) {
						var form = $(this);
						//$("#createpayementCoomandeBtn").button('loading');
						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),	
							dataType: 'json',
								success:function(response){
									$("#createpayementCoomandeBtn").button('reset');
									if(response.success == true) {

										// hide the remove modal  
										$('#addPayementCommandeModal').modal('hide');

										// reload the brand table 
										$("#getpaiementCommandeForm")[0].reset();
										manageCommandeTable.ajax.reload(null, false);
										
										$('.remove-messages').html('<div class="alert alert-success">'+
								            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
								          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
												$(this).remove();
											});
										}); // /.alert
									}else {
										$('.remove-messages').html('<div class="alert alert-danger">'+
								            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
								          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
											$(this).remove();
											});
										}); // /.alert
							} // /else
							}
						});
					}
					return false;

					});

			}

		});

	}
	return false;

}

function attacheFacture(id_commande = null) {
	if(id_commande) {
		
		$.ajax({
			url: 'php_action/fetchSelectedCommande.php',
			type: 'post',
			data: {id_commande : id_commande},
			dataType: 'json',
			success:function(response) {
				//$('.removeBrandFooter').after('<input type="hidden" name="id_commande" id="id_commande" value="'+response.id_commande+'" /> ');
				$("#id_commande").val(response.id_commande);
				$("#factureAttache").text(response.ref_commande);
				// click on remove button to remove the brand
				$("#submitBordereauCommandeForm").unbind('submit').bind('submit', function() {

					

					var form = $(this);
					// button loading
					$("#createBordereauBtn").button('loading');

					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
							// button loading
							$("#createBordereauBtn").button('reset');
							if(response.success == true) {
								$("#submitBordereauCommandeForm")[0].reset();

								// hide the remove modal 
								$('#attacheFactureCommandeModal').modal('hide');

								// reload the brand table 
								manageCommandeTable.ajax.reload(null, false);
								
								$('.remove-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="fa fa-check"></i></strong> '+ response.messages +
						          '</div>');

				  	  			$(".alert-success").delay(500).show(10, function() {
									$(this).delay(3000).hide(10, function() {
										$(this).remove();
									});
								}); // /.alert
							} else {
								$('.remove-messages').html('<div class="alert alert-danger">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="fa fa-remove"></i></strong> '+ response.messages +
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

function viewCommande(commandeId = null){

	var table='<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Produit</th><th scope="col">Quantité</th><th scope="col">PU</th><th scope="col">PT-HTVA</th></tr></thead>';
	if(commandeId) {
		$.ajax({
			url: 'php_action/fetchCommandeDataDetail.php',
			type: 'post',
			data: {commandeId: commandeId},
			dataType: 'json',
			success:function(response){

				$("#tableDatail").html(response);
			}
		});
	}	
}

function removeCommande(id_commande = null) {
	if(id_commande) {
		$('#removeCommandeId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedCommande.php',
			type: 'post',
			data: {id_commande : id_commande},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeCommandeId" id="removeCommandeId" value="'+response.id_commande+'" /> ');
				$("#supprimer").text(response.ref_commande);
				// click on remove button to remove the brand
				$("#removeCommandeBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeCommandeBtn").button('loading');

					$.ajax({
						url: 'php_action/removeCommande.php',
						type: 'post',
						data: {id_commande : id_commande},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeCommandeBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeCommnandeModal').modal('hide');

								// reload the brand table 
								manageCommandeTable.ajax.reload(null, false);
								
								$('.remove-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="fa fa-check"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
													$(this).delay(3000).hide(10, function() {
														$(this).remove();
													});
												}); // /.alert
							} else {
								$('.remove-messages').html('<div class="alert alert-danger">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="fa fa-remove"></i></strong> '+ response.messages +
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